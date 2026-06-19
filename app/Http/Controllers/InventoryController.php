<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Notifications\LowStockNotification;
use App\Notifications\OutOfStockNotification;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $allProducts = Product::where('user_id', auth()->id())->get();

        $query = Product::where('user_id', auth()->id());

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name',        'like', '%' . $search . '%')
                  ->orWhere('category',    'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'in_stock') {
                $query->where('stock_quantity', '>', 0)
                      ->whereColumn('stock_quantity', '>', 'low_stock_threshold');
            }
            if ($request->status === 'low_stock') {
                $query->where('stock_quantity', '>', 0)
                      ->whereColumn('stock_quantity', '<=', 'low_stock_threshold');
            }
            if ($request->status === 'out_of_stock') {
                $query->where('stock_quantity', 0);
            }
        }

        $products = $query->orderByRaw('product_date IS NULL')
            ->orderBy('product_date', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('inventory.index', compact('products', 'allProducts'));
    }

    public function create()
    {
        $categories = Product::where('user_id', auth()->id())
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->whereNotIn('category', ['Product', 'Other'])
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('inventory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'stock_quantity'     => 'required|integer|min:0',
            'low_stock_threshold'=> 'required|integer|min:1',
            'price'              => 'required|numeric|min:0',
            'category'           => 'required|string|max:255',
            'custom_category'    => 'required_if:category,Other|nullable|string|max:255',
            'product_date'       => 'required|date|before_or_equal:today',
            'description'        => 'nullable|string',

            // Purchase expense fields — required only when stock > 0
            'purchase_cost'      => 'required_if:stock_quantity_gt_zero,1|nullable|numeric|min:0',
            'payment_method'     => 'required_if:stock_quantity_gt_zero,1|nullable|string|max:255',
        ], [
            'product_date.before_or_equal' => 'Product date cannot be in the future.',
            'purchase_cost.required_if'    => 'Please enter the purchase cost per unit.',
            'payment_method.required_if'   => 'Please select a payment method.',
        ]);

        $finalCategory = $request->category === 'Other'
            ? trim($request->custom_category)
            : trim($request->category);

        $product = Product::create([
            'user_id'             => auth()->id(),
            'name'                => trim($request->name),
            'stock_quantity'      => $request->stock_quantity,
            'low_stock_threshold' => $request->low_stock_threshold,
            'price'               => $request->price,
            'category'            => $finalCategory,
            'product_date'        => $request->product_date,
            'description'         => $request->description,
        ]);

        // ── Auto-create expense transaction for initial stock purchase ──
        if ($request->stock_quantity > 0 && $request->filled('purchase_cost')) {
            $purchaseCost = (float) $request->purchase_cost;
            $totalCost    = $purchaseCost * (int) $request->stock_quantity;

            Transaction::create([
                'user_id'        => auth()->id(),
                'type'           => 'expense',
                'category'       => 'Stock Purchase / Restock',
                'product_id'     => $product->id,
                'quantity'       => (int) $request->stock_quantity,
                'amount'         => $totalCost,
                'description'    => 'Initial stock purchase for: ' . $product->name,
                'payment_method' => $request->payment_method,
                'date'           => $request->product_date,
            ]);
        }

        // Notifications
        if ($product->stock_quantity == 0) {
            auth()->user()->notify(new OutOfStockNotification($product->name));
        } elseif ($product->stock_quantity <= $product->low_stock_threshold) {
            auth()->user()->notify(new LowStockNotification($product->name, $product->stock_quantity));
        }

        $msg = 'Product added successfully.';
        if ($request->stock_quantity > 0 && $request->filled('purchase_cost')) {
            $total = number_format((float)$request->purchase_cost * (int)$request->stock_quantity, 2);
            $msg = 'Product added and expense of RM' . $total . ' recorded for initial stock purchase.';
        }

        return redirect()->route('inventory.index')->with('success', $msg);
    }
}