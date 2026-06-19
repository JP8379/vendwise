<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\SystemLog;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpenses = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $totalSales = Transaction::where('user_id', $userId)
            ->where('type', 'sale')
            ->sum('amount');

        $profit = ($totalIncome + $totalSales) - $totalExpenses;

        $totalTransactions = Transaction::where('user_id', $userId)->count();

        $totalProducts = 0;
        $lowStockCount = 0;

        if (class_exists(Product::class)) {
            $totalProducts = Product::where('user_id', $userId)->count();

            $lowStockCount = Product::where('user_id', $userId)
                ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                ->count();
        }

        // --- Welcome banner logic ---
        // isNewUser = no transactions AND no products yet
        $isNewUser = ($totalTransactions === 0 && $totalProducts === 0);

        // hasPartialData = has products but no transactions, or vice versa
        // Show a softer "getting started" nudge instead of full welcome
        $hasPartialData = !$isNewUser && (
            ($totalTransactions === 0 && $totalProducts > 0) ||
            ($totalTransactions > 0 && $totalProducts === 0)
        );

        $recentTransactions = Transaction::where('user_id', $userId)
            ->latest('date')
            ->take(5)
            ->get();

        $monthLabels     = [];
        $monthlyIncome   = [];
        $monthlyExpenses = [];
        $monthlyProfit   = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            $monthLabels[] = $month->format('M');

            $income = Transaction::where('user_id', $userId)
                ->whereIn('type', ['income', 'sale'])
                ->whereYear('date',  $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');

            $expense = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereYear('date',  $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');

            $monthlyIncome[]   = (float) $income;
            $monthlyExpenses[] = (float) $expense;
            $monthlyProfit[]   = (float) ($income - $expense);
        }

        /*
        |--------------------------------------------------------------------------
        | Smart Business Suggestions
        |--------------------------------------------------------------------------
        */

        $smartSuggestions = [];

        // No data at all — only show one onboarding tip
        if ($isNewUser) {
            $smartSuggestions[] = [
                'type'    => 'warning',
                'icon'    => '📝',
                'title'   => 'Start recording transactions',
                'message' => 'No transactions have been added yet. Add income, sales, and expenses to generate useful insights.',
            ];
        } else {
            // Profit status
            if ($profit > 0) {
                $smartSuggestions[] = [
                    'type'    => 'success',
                    'icon'    => '📈',
                    'title'   => 'Business is profitable',
                    'message' => 'Your business is currently making profit. Keep maintaining expenses below your income and sales.',
                ];
            } elseif ($profit < 0) {
                $smartSuggestions[] = [
                    'type'    => 'danger',
                    'icon'    => '⚠️',
                    'title'   => 'Loss detected',
                    'message' => 'Your expenses are higher than your income and sales. Review spending and reduce unnecessary costs.',
                ];
            }

            // Expenses too high
            if ($totalExpenses > ($totalIncome + $totalSales) && ($totalIncome + $totalSales) > 0) {
                $smartSuggestions[] = [
                    'type'    => 'danger',
                    'icon'    => '💸',
                    'title'   => 'Expenses are too high',
                    'message' => 'Your expenses exceed your total income. Check expense categories and control high-cost areas.',
                ];
            }

            // No sales recorded
            if ($totalSales == 0 && $totalTransactions > 0) {
                $smartSuggestions[] = [
                    'type'    => 'warning',
                    'icon'    => '🛒',
                    'title'   => 'No sales recorded',
                    'message' => 'You have transactions recorded but no sales. Make sure sales transactions are entered correctly.',
                ];
            }

            // Month-over-month profit trend
            $currentMonthProfit  = count($monthlyProfit) > 0 ? end($monthlyProfit) : 0;
            $previousMonthProfit = count($monthlyProfit) > 1 ? $monthlyProfit[count($monthlyProfit) - 2] : 0;

            if ($currentMonthProfit > $previousMonthProfit && $previousMonthProfit > 0) {
                $smartSuggestions[] = [
                    'type'    => 'success',
                    'icon'    => '🚀',
                    'title'   => 'Profit is improving',
                    'message' => 'Your current month profit is higher than last month. Continue using the strategies that improved your sales.',
                ];
            } elseif ($currentMonthProfit < $previousMonthProfit && $previousMonthProfit > 0) {
                $smartSuggestions[] = [
                    'type'    => 'warning',
                    'icon'    => '📉',
                    'title'   => 'Profit dropped',
                    'message' => 'Your profit is lower than last month. Review sales performance and expense changes.',
                ];
            }

            // No recent sales
            $last7DaysSales = Transaction::where('user_id', $userId)
                ->where('type', 'sale')
                ->whereDate('date', '>=', Carbon::now()->subDays(7))
                ->sum('amount');

            if ($last7DaysSales == 0 && $totalTransactions > 0) {
                $smartSuggestions[] = [
                    'type'    => 'warning',
                    'icon'    => '📢',
                    'title'   => 'No recent sales',
                    'message' => 'No sales were recorded in the last 7 days. Consider promotions or checking your product availability.',
                ];
            }

            // Low stock
            if ($lowStockCount > 0) {
                $smartSuggestions[] = [
                    'type'    => 'warning',
                    'icon'    => '📦',
                    'title'   => 'Low stock alert',
                    'message' => $lowStockCount . ' product(s) are low in stock. Restock soon to avoid missed sales.',
                ];
            }

            // No issues found
            if (empty($smartSuggestions)) {
                $smartSuggestions[] = [
                    'type'    => 'success',
                    'icon'    => '✅',
                    'title'   => 'Business looks stable',
                    'message' => 'No major issues detected. Continue monitoring sales, expenses, and inventory regularly.',
                ];
            }
        }

        $smartSuggestions = array_slice($smartSuggestions, 0, 4);

        return view('dashboard', compact(
            'totalIncome',
            'totalSales',
            'totalExpenses',
            'profit',
            'totalTransactions',
            'totalProducts',
            'recentTransactions',
            'monthLabels',
            'monthlyIncome',
            'monthlyExpenses',
            'monthlyProfit',
            'smartSuggestions',
            'lowStockCount',
            'isNewUser',
            'hasPartialData'
        ));
    }

    public function adminIndex()
    {
        $totalVendors = User::where('role', 'vendor')->count();

        $activeVendors = User::where('role', 'vendor')
            ->where('status', 'active')
            ->count();

        $deactivatedVendors = User::where('role', 'vendor')
            ->where('status', 'deactivated')
            ->count();

        $recentVendors = User::where('role', 'vendor')
            ->latest()
            ->take(5)
            ->get();

        $systemLogs = SystemLog::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalVendors',
            'activeVendors',
            'deactivatedVendors',
            'recentVendors',
            'systemLogs'
        ));
    }
}