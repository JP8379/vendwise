<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index($period = 'daily')
    {
        $userId = auth()->id();

        if (!in_array($period, ['daily', 'monthly', 'yearly'])) {
            $period = 'daily';
        }

        $totalSales = Transaction::where('user_id', $userId)
            ->where('type', 'sale')
            ->sum('amount');

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpenses = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $netProfit = ($totalSales + $totalIncome) - $totalExpenses;

        $summary = [
            'total_sales' => $totalSales,
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_profit' => $netProfit,
        ];

        if ($period === 'daily') {
            $rows = Transaction::select(
                    DB::raw("DATE(date) as label"),
                    DB::raw("SUM(CASE WHEN type = 'sale' THEN amount ELSE 0 END) as sales"),
                    DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income"),
                    DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expenses")
                )
                ->where('user_id', $userId)
                ->groupBy(DB::raw("DATE(date)"))
                ->orderBy(DB::raw("DATE(date)"))
                ->get();

            $trendLabels = $rows->pluck('label')->map(fn($d) => date('d M', strtotime($d)))->values();
        } elseif ($period === 'monthly') {
            $rows = Transaction::select(
                    DB::raw("YEAR(date) as year"),
                    DB::raw("MONTH(date) as month"),
                    DB::raw("SUM(CASE WHEN type = 'sale' THEN amount ELSE 0 END) as sales"),
                    DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income"),
                    DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expenses")
                )
                ->where('user_id', $userId)
                ->groupBy(DB::raw("YEAR(date)"), DB::raw("MONTH(date)"))
                ->orderBy(DB::raw("YEAR(date)"))
                ->orderBy(DB::raw("MONTH(date)"))
                ->get();

            $monthNames = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
                9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
            ];

            $trendLabels = $rows->map(fn($row) => $monthNames[$row->month] . ' ' . $row->year)->values();
        } else {
            $rows = Transaction::select(
                    DB::raw("YEAR(date) as label"),
                    DB::raw("SUM(CASE WHEN type = 'sale' THEN amount ELSE 0 END) as sales"),
                    DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income"),
                    DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expenses")
                )
                ->where('user_id', $userId)
                ->groupBy(DB::raw("YEAR(date)"))
                ->orderBy(DB::raw("YEAR(date)"))
                ->get();

            $trendLabels = $rows->pluck('label')->values();
        }

        $salesData = [];
        $profitData = [];
        $expensesData = [];

        foreach ($rows as $row) {
            $sales = (float) $row->sales;
            $income = (float) $row->income;
            $expenses = (float) $row->expenses;

            $salesData[] = $sales;
            $expensesData[] = $expenses;
            $profitData[] = ($sales + $income) - $expenses;
        }

        $distribution = [
            'sales' => $totalSales,
            'other_income' => $totalIncome,
            'expenses' => $totalExpenses,
        ];

        return view('reports.index', compact(
            'summary',
            'trendLabels',
            'salesData',
            'profitData',
            'expensesData',
            'distribution',
            'period'
        ));
    }
}