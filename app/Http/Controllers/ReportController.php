<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use App\Models\Transaction;

class ReportController extends Controller
{
    /**
     * Shared helper: build date range + query filter based on period
     */
    private function buildPeriodQuery($period, $query)
    {
        $reportStart = $reportEnd = now();

        switch ($period) {
            case 'daily':
                $reportStart = Carbon::today();
                $reportEnd   = Carbon::today();
                $query->whereDate('date', $reportStart);
                break;

            case 'weekly':
                $reportStart = Carbon::now()->startOfWeek();
                $reportEnd   = Carbon::now()->endOfWeek();
                $query->whereBetween('date', [$reportStart, $reportEnd]);
                break;

            case 'yearly':
                $reportStart = Carbon::now()->startOfYear();
                $reportEnd   = Carbon::now()->endOfYear();
                $query->whereYear('date', $reportStart->year);
                break;

            case 'monthly':
            default:
                $period      = 'monthly';
                $reportStart = Carbon::now()->startOfMonth();
                $reportEnd   = Carbon::now()->endOfMonth();
                $query->whereMonth('date', $reportStart->month)
                      ->whereYear('date', $reportStart->year);
                break;
        }

        return [$period, $reportStart, $reportEnd, $query];
    }

    /**
     * Shared helper: build grouped trend data from transactions
     * For yearly: group by month label (Jan, Feb, ...)
     * For weekly: group by day name (Mon, Tue, ...)
     * For daily/monthly: group by dd/mm/yyyy
     */
    private function buildTrendData($transactions, $period)
    {
        if ($period === 'yearly') {
            $grouped = $transactions->groupBy(
                fn($t) => Carbon::parse($t->date)->format('M Y')
            );
        } elseif ($period === 'weekly') {
            $grouped = $transactions->groupBy(
                fn($t) => Carbon::parse($t->date)->format('D d/m')
            );
        } else {
            $grouped = $transactions->groupBy(
                fn($t) => Carbon::parse($t->date)->format('d/m/Y')
            );
        }

        $trendLabels  = $grouped->keys()->toArray();
        $salesData    = $grouped->map(fn($g) => $g->where('type', 'sale')->sum('amount'))->values()->toArray();
        $incomeData   = $grouped->map(fn($g) => $g->where('type', 'income')->sum('amount'))->values()->toArray();
        $expensesData = $grouped->map(fn($g) => $g->where('type', 'expense')->sum('amount'))->values()->toArray();
        $profitData   = $grouped->map(fn($g) =>
            $g->where('type', 'sale')->sum('amount') +
            $g->where('type', 'income')->sum('amount') -
            $g->where('type', 'expense')->sum('amount')
        )->values()->toArray();

        return [$trendLabels, $salesData, $incomeData, $expensesData, $profitData];
    }

    /**
     * Shared helper: build smart suggestions based on financial data
     */
    private function buildSmartSuggestions($netProfit, $totalSales, $totalIncome, $totalExpenses, $period)
    {
        $smartSuggestions = [];
        $totalRevenue     = $totalSales + $totalIncome;
        $profitMargin     = $totalRevenue > 0 ? ($netProfit / $totalRevenue) * 100 : 0;
        $periodLabel      = ucfirst($period);

        // Profit status
        if ($netProfit > 0) {
            $smartSuggestions[] = [
                'title'   => 'Healthy Profit',
                'message' => "Your net profit is positive for this {$periodLabel} period. Keep up the current sales strategy.",
                'type'    => 'success',
            ];
        } elseif ($netProfit < 0) {
            $smartSuggestions[] = [
                'title'   => 'Profit Warning',
                'message' => "Net profit is negative for this {$periodLabel} period. Consider reviewing expenses or increasing sales.",
                'type'    => 'danger',
            ];
        } else {
            $smartSuggestions[] = [
                'title'   => 'Break-even',
                'message' => "Net profit is zero for this {$periodLabel} period. Check if income and expenses are balanced.",
                'type'    => 'warning',
            ];
        }

        // Low profit margin
        if ($profitMargin < 5 && $totalRevenue > 0) {
            $smartSuggestions[] = [
                'title'   => 'Low Profit Margin',
                'message' => "Your profit margin is below 5% ({$periodLabel}). Try reducing costs or increasing your prices.",
                'type'    => 'danger',
            ];
        } elseif ($profitMargin >= 15 && $totalRevenue > 0) {
            $smartSuggestions[] = [
                'title'   => 'Strong Profit Margin',
                'message' => "Excellent! Your profit margin is above 15% ({$periodLabel}). Consider reinvesting in growth.",
                'type'    => 'success',
            ];
        }

        // Expenses vs sales
        if ($totalExpenses > $totalSales && $totalSales > 0) {
            $smartSuggestions[] = [
                'title'   => 'Expenses Exceed Sales',
                'message' => "Your expenses are higher than your sales revenue this {$periodLabel}. Review your spending carefully.",
                'type'    => 'danger',
            ];
        }

        // No transactions
        if ($totalRevenue === 0 && $totalExpenses === 0) {
            $smartSuggestions = [[
                'title'   => 'No Data',
                'message' => "No transactions found for this {$periodLabel} period. Add transactions to generate insights.",
                'type'    => 'warning',
            ]];
        }

        return $smartSuggestions;
    }

    /**
     * Show report page
     */
    public function index(Request $request, $period = 'monthly')
    {
        $user = auth()->user();

        $transactionsQuery = Transaction::where('user_id', $user->id);

        [$period, $reportStart, $reportEnd, $transactionsQuery] =
            $this->buildPeriodQuery($period, $transactionsQuery);

        $transactions = $transactionsQuery->orderBy('date', 'asc')->get();

        // Totals
        $totalSales    = $transactions->where('type', 'sale')->sum('amount');
        $totalIncome   = $transactions->where('type', 'income')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        $netProfit     = $totalSales + $totalIncome - $totalExpenses;

        $summary = [
            'total_sales'    => $totalSales,
            'total_income'   => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_profit'     => $netProfit,
        ];

        $distribution = [
            'sales'        => $totalSales,
            'other_income' => $totalIncome,
            'expenses'     => $totalExpenses,
        ];

        [$trendLabels, $salesData, $incomeData, $expensesData, $profitData] =
            $this->buildTrendData($transactions, $period);

        $smartSuggestions = $this->buildSmartSuggestions(
            $netProfit, $totalSales, $totalIncome, $totalExpenses, $period
        );

        $reportPeriodLabel = ucfirst($period);
        $reportRange       = $reportStart->format('d/m/Y') . ' - ' . $reportEnd->format('d/m/Y');

        return view('reports.index', compact(
            'summary',
            'distribution',
            'trendLabels',
            'salesData',
            'incomeData',
            'expensesData',
            'profitData',
            'smartSuggestions',
            'period',
            'reportPeriodLabel',
            'reportRange'
        ));
    }

    /**
     * Generate PDF report
     */
    public function generatePDF(Request $request, $period = 'monthly')
    {
        $user = auth()->user();

        $transactionsQuery = Transaction::where('user_id', $user->id);

        [$period, $reportStart, $reportEnd, $transactionsQuery] =
            $this->buildPeriodQuery($period, $transactionsQuery);

        $transactions = $transactionsQuery->orderBy('date', 'asc')->get();

        $totalSales    = $transactions->where('type', 'sale')->sum('amount');
        $totalIncome   = $transactions->where('type', 'income')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        $netProfit     = $totalSales + $totalIncome - $totalExpenses;

        [$trendLabels, $salesData, $incomeData, $expensesData, $profitData] =
            $this->buildTrendData($transactions, $period);

        $smartSuggestions = $this->buildSmartSuggestions(
            $netProfit, $totalSales, $totalIncome, $totalExpenses, $period
        );

        $totalRevenue = $totalSales + $totalIncome;
        $profitMargin = $totalRevenue > 0 ? ($netProfit / $totalRevenue) * 100 : 0;
        $expenseRatio = $totalRevenue > 0 ? ($totalExpenses / $totalRevenue) * 100 : 0;

        $data = [
            'transactions'      => $transactions,
            'summary' => [
                'total_sales'    => $totalSales,
                'total_income'   => $totalIncome,
                'total_expenses' => $totalExpenses,
                'net_profit'     => $netProfit,
            ],
            'distribution' => [
                'sales'        => $totalSales,
                'other_income' => $totalIncome,
                'expenses'     => $totalExpenses,
            ],
            'trendLabels'       => $trendLabels,
            'salesData'         => $salesData,
            'incomeData'        => $incomeData,
            'expensesData'      => $expensesData,
            'profitData'        => $profitData,
            'smartSuggestions'  => $smartSuggestions,
            'profitMargin'      => $profitMargin,
            'expenseRatio'      => $expenseRatio,
            'businessName'      => $user->business_name ?? $user->name,
            'period'            => ucfirst($period),
            'reportRange'       => $reportStart->format('d/m/Y') . ' - ' . $reportEnd->format('d/m/Y'),
            'generatedAt'       => now('Asia/Kuala_Lumpur')->format('d/m/Y h:i A'),
            'logoPath'          => public_path('images/v-logo.png'),
            // Chart images from browser canvas
            'salesExpenseChart' => $request->input('sales_expense_chart'),
            'distributionChart' => $request->input('distribution_chart'),
            'profitChart'       => $request->input('profit_chart'),
        ];

        $pdf = PDF::loadView('reports.pdf', $data)
                  ->setPaper('A4', 'portrait');

        $fileName = 'vendwise-' . $period . '-report-' . now('Asia/Kuala_Lumpur')->format('Ymd-His') . '.pdf';

        return $pdf->download($fileName);
    }
}