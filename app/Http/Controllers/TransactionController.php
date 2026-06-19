<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Notifications\NewTransactionNotification;
use App\Notifications\LowStockNotification;
use App\Notifications\OutOfStockNotification;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('product')
            ->where('user_id', auth()->id());

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', strtolower($request->type));
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $keywords = collect(explode(' ', $search))
                ->filter()
                ->values();

            $query->where(function ($mainQuery) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $mainQuery->where(function ($q) use ($keyword) {
                        $q->where('category', 'like', '%' . $keyword . '%')
                            ->orWhere('description', 'like', '%' . $keyword . '%')
                            ->orWhere('payment_method', 'like', '%' . $keyword . '%')
                            ->orWhere('type', 'like', '%' . $keyword . '%')
                            ->orWhere('amount', 'like', '%' . $keyword . '%')
                            ->orWhereHas('product', function ($productQuery) use ($keyword) {
                                $productQuery->where('name', 'like', '%' . $keyword . '%');
                            });
                    });
                }
            });
        }

        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('type')
            ->orderBy('name')
            ->get()
            ->groupBy('type');

        $products = Product::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('transactions.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:income,expense,sale',

            'category' => 'nullable|required_unless:expense_mode,restock|string|max:255',
            'custom_category' => 'nullable|required_if:category,Other|string|max:255',

            'expense_mode' => 'nullable|string|in:normal,restock',

            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'payment_method' => 'required|string',

            'date' => 'required|date|before_or_equal:today',

            'product_id' => 'nullable|required_if:type,sale|exists:products,id',
            'quantity' => 'nullable|required_if:type,sale|integer|min:1',

            'restock_product_id' => 'nullable|required_if:expense_mode,restock|exists:products,id',
            'restock_quantity' => 'nullable|required_if:expense_mode,restock|integer|min:1',
            'unit_cost' => 'nullable|required_if:expense_mode,restock|numeric|min:0',
        ], [
            'date.required' => 'Please select the transaction date.',
            'date.date' => 'Please enter a valid transaction date.',
            'date.before_or_equal' => 'Transaction date cannot be in the future.',

            'product_id.required_if' => 'Please select the product sold.',
            'quantity.required_if' => 'Please enter the quantity sold.',

            'restock_product_id.required_if' => 'Please select the product restocked.',
            'restock_quantity.required_if' => 'Please enter the quantity added.',
            'unit_cost.required_if' => 'Please enter the unit cost.',
        ]);

        $type = strtolower($request->type);
        $expenseMode = $request->expense_mode ?? 'normal';

        if ($type === 'expense' && $expenseMode === 'restock') {
            $categoryName = 'Stock Purchase / Restock';
        } else {
            $categoryName = $request->category === 'Other'
                ? trim($request->custom_category)
                : trim($request->category);
        }

        $toastMessage = 'Transaction saved successfully.';

        DB::transaction(function () use ($request, $type, $expenseMode, $categoryName, &$toastMessage) {
            $product = null;
            $quantity = null;
            $amount = $request->amount;
            $previousStock = null;

            if ($type === 'sale') {
                $product = Product::where('user_id', auth()->id())
                    ->where('id', $request->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $request->quantity;
                $previousStock = $product->stock_quantity;

                if ($previousStock < $quantity) {
                    throw ValidationException::withMessages([
                        'quantity' => 'Not enough stock available. Current stock: ' . $previousStock,
                    ]);
                }

                $amount = $product->price * $quantity;

                $product->decrement('stock_quantity', $quantity);
                $product->refresh();
            }

            if ($type === 'expense' && $expenseMode === 'restock') {
                $product = Product::where('user_id', auth()->id())
                    ->where('id', $request->restock_product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $request->restock_quantity;
                $unitCost = (float) $request->unit_cost;
                $previousStock = $product->stock_quantity;

                $amount = $quantity * $unitCost;

                $product->increment('stock_quantity', $quantity);
                $product->refresh();
            }

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'type' => $type,
                'category' => $categoryName,
                'product_id' => $product?->id,
                'quantity' => $quantity,
                'amount' => $amount,
                'description' => $request->description,
                'payment_method' => $request->payment_method,
                'date' => $request->date,
            ]);

            Category::firstOrCreate([
                'user_id' => auth()->id(),
                'name' => $categoryName,
                'type' => $type,
            ]);

            auth()->user()->notify(
                new NewTransactionNotification(
                    $transaction->type,
                    $transaction->category,
                    $transaction->amount
                )
            );

            $toastMessage = ucfirst($transaction->type)
                . ' transaction saved successfully. Amount: RM '
                . number_format($transaction->amount, 2)
                . '.';

            if ($type === 'sale' && $product) {
                $currentStock = $product->stock_quantity;

                if ($currentStock == 0 && $previousStock > 0) {
                    auth()->user()->notify(
                        new OutOfStockNotification($product->name)
                    );

                    $toastMessage = 'Sale transaction saved. Warning: '
                        . $product->name
                        . ' is now out of stock.';
                } elseif (
                    $currentStock <= $product->low_stock_threshold &&
                    $previousStock > $product->low_stock_threshold
                ) {
                    auth()->user()->notify(
                        new LowStockNotification(
                            $product->name,
                            $currentStock
                        )
                    );

                    $toastMessage = 'Sale transaction saved. Low stock alert: '
                        . $product->name
                        . ' only has '
                        . $currentStock
                        . ' left.';
                }
            }

            if ($type === 'expense' && $expenseMode === 'restock' && $product) {
                $toastMessage = 'Restock expense saved. '
                    . $product->name
                    . ' stock increased from '
                    . $previousStock
                    . ' to '
                    . $product->stock_quantity
                    . '. Amount: RM '
                    . number_format($amount, 2)
                    . '.';
            }

            auth()->user()->update([
                'is_new' => false,
            ]);
        });

        return redirect()->route('transactions.index')
            ->with('success', $toastMessage);
    }
}