<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VendWise {{ $period }} Report - {{ $businessName }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            color: #1f2937;
            background: #ffffff;
            font-size: 12px;
            line-height: 1.5;
        }

        /* ===================== COVER HEADER ===================== */
        .cover-header {
            background: #1e3a8a;
            padding: 0;
            margin-bottom: 20px;
        }

        /* Top blue bar: logo + brand */
        .cover-top-bar {
            background: #1e3a8a;
            padding: 22px 28px 18px 28px;
            border-bottom: 3px solid #3b82f6;
        }

        .cover-top-inner {
            display: table;
            width: 100%;
        }

        .cover-logo-cell {
            display: table-cell;
            vertical-align: middle;
            width: 70px;
        }

        .logo-box {
            width: 56px;
            height: 56px;
            background: #ffffff;
            border-radius: 10px;
            padding: 5px;
            text-align: center;
        }

        .logo-box img {
            width: 46px;
            height: 46px;
            object-fit: contain;
        }

        .logo-fallback-box {
            width: 56px;
            height: 56px;
            background: #ffffff;
            border-radius: 10px;
            text-align: center;
            line-height: 56px;
            font-size: 28px;
            font-weight: 900;
            color: #1d4ed8;
        }

        .cover-brand-cell {
            display: table-cell;
            vertical-align: middle;
            padding-left: 14px;
        }

        .brand-name {
            font-size: 24px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .brand-sub {
            font-size: 9px;
            color: rgba(255,255,255,0.7);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Bottom info bar */
        .cover-info-bar {
            background: #1e40af;
            padding: 18px 28px;
        }

        .cover-info-table {
            display: table;
            width: 100%;
        }

        .cover-info-left {
            display: table-cell;
            vertical-align: top;
            width: 65%;
        }

        .cover-info-right {
            display: table-cell;
            vertical-align: top;
            text-align: right;
        }

        .report-main-title {
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .info-rows { }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }

        .info-row-label {
            display: table-cell;
            width: 115px;
            font-size: 10px;
            font-weight: bold;
            color: rgba(255,255,255,0.65);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            vertical-align: top;
        }

        .info-row-val {
            display: table-cell;
            font-size: 11px;
            color: #ffffff;
            vertical-align: top;
        }

        .info-note {
            margin-top: 10px;
            font-size: 9px;
            color: rgba(255,255,255,0.55);
            font-style: italic;
            line-height: 1.6;
            max-width: 350px;
        }

        .period-badge {
            display: inline-block;
            border: 1.5px solid rgba(255,255,255,0.5);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 10px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .cover-right-desc {
            font-size: 10px;
            color: rgba(255,255,255,0.65);
            line-height: 1.8;
            text-align: right;
        }

        /* ===================== SECTION TITLE ===================== */
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 18px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #dbeafe;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* ===================== SUMMARY CARDS ===================== */
        .summary-table {
            display: table;
            width: 100%;
            border-spacing: 8px;
            margin-bottom: 4px;
        }

        .summary-row { display: table-row; }

        .s-card {
            display: table-cell;
            width: 25%;
            border-radius: 8px;
            padding: 12px 12px;
            border-top: 3px solid;
            vertical-align: top;
        }

        .s-card.c-sales   { border-color: #2563eb; background: #eff6ff; }
        .s-card.c-income  { border-color: #16a34a; background: #f0fdf4; }
        .s-card.c-expense { border-color: #dc2626; background: #fef2f2; }
        .s-card.c-profit  { border-color: #059669; background: #ecfdf5; }
        .s-card.c-loss    { border-color: #dc2626; background: #fef2f2; }

        .s-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .s-value { font-size: 16px; font-weight: 900; }
        .s-sub   { font-size: 9px; color: #9ca3af; margin-top: 3px; }

        .col-blue   { color: #2563eb; }
        .col-green  { color: #16a34a; }
        .col-red    { color: #dc2626; }
        .col-emerald{ color: #059669; }

        /* ===================== RATIO TABLE ===================== */
        .std-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .std-table thead tr { background: #1e3a8a; color: #ffffff; }

        .std-table th {
            padding: 8px 10px;
            font-size: 9.5px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .std-table td {
            padding: 8px 10px;
            font-size: 11px;
            border-bottom: 1px solid #f0f0f0;
        }

        .std-table tr:nth-child(even) td { background: #f9fafb; }

        .badge {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 9.5px;
            font-weight: bold;
        }

        .badge-green  { background: #d1fae5; color: #065f46; }
        .badge-orange { background: #ffedd5; color: #9a3412; }
        .badge-red    { background: #fee2e2; color: #991b1b; }
        .badge-blue   { background: #dbeafe; color: #1e40af; }

        /* ===================== SUGGESTIONS ===================== */
        .suggestion {
            padding: 9px 12px;
            border-radius: 7px;
            margin-bottom: 7px;
            font-size: 11px;
            border-left: 4px solid;
        }

        .suggestion.success { background: #d1fae5; color: #065f46; border-color: #10b981; }
        .suggestion.danger  { background: #fee2e2; color: #991b1b; border-color: #ef4444; }
        .suggestion.warning { background: #fff7ed; color: #92400e; border-color: #f59e0b; }
        .suggestion.info    { background: #eff6ff; color: #1e40af; border-color: #3b82f6; }

        .sug-top {
            display: table;
            width: 100%;
            margin-bottom: 3px;
        }

        .sug-title-cell {
            display: table-cell;
            font-weight: bold;
            font-size: 11px;
            vertical-align: middle;
        }

        .sug-badge-cell {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            width: 70px;
        }

        .sug-badge {
            display: inline-block;
            font-size: 9px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .sug-badge.good     { background: #bbf7d0; color: #14532d; }
        .sug-badge.critical { background: #fecaca; color: #7f1d1d; }
        .sug-badge.attention{ background: #fed7aa; color: #7c2d12; }

        .sug-msg { font-size: 10.5px; line-height: 1.5; }

        /* ===================== PERF + DIST CARDS ===================== */
        .cards-table {
            display: table;
            width: 100%;
            border-spacing: 8px;
            margin-bottom: 4px;
        }

        .cards-row { display: table-row; }

        .perf-card {
            display: table-cell;
            width: 33.33%;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 11px 12px;
            background: #f9fafb;
            text-align: center;
            vertical-align: top;
        }

        .p-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .p-value { font-size: 15px; font-weight: 900; }

        .dist-card {
            display: table-cell;
            width: 33.33%;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 11px 12px;
            background: #f9fafb;
            vertical-align: top;
        }

        .d-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .d-value { font-size: 15px; font-weight: 900; }

        .dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 4px; }
        .dot-blue  { background: #2563eb; }
        .dot-green { background: #22c55e; }
        .dot-red   { background: #ef4444; }

        /* ===================== TREND TABLE ===================== */
        .trend-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .trend-table thead tr { background: #1e3a8a; color: #fff; }
        .trend-table th { padding: 8px 10px; font-size: 9.5px; font-weight: bold; text-align: left; text-transform: uppercase; letter-spacing: 0.4px; }
        .trend-table th:not(:first-child) { text-align: right; }
        .trend-table td { padding: 7px 10px; font-size: 11px; border-bottom: 1px solid #f0f0f0; }
        .trend-table td:not(:first-child) { text-align: right; }
        .trend-table tr:nth-child(even) td { background: #f9fafb; }
        .trend-table tfoot td { background: #f1f5f9 !important; font-weight: bold; font-size: 11px; border-top: 2px solid #dbeafe; }

        /* ===================== PAGE BREAK ===================== */
        .page-break { page-break-before: always; }

        /* ===================== CHARTS ===================== */
        .charts-header {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
        }

        .charts-header h2 { font-size: 14px; font-weight: bold; color: #1e3a8a; margin-bottom: 3px; }
        .charts-header p  { font-size: 10px; color: #6b7280; }

        .chart-block {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 18px;
            background: #ffffff;
        }

        .chart-block-title { font-size: 12px; font-weight: bold; color: #1e3a8a; margin-bottom: 6px; }

        .chart-desc {
            font-size: 10px;
            color: #6b7280;
            padding: 7px 11px;
            border-left: 3px solid #3b82f6;
            background: #f8fafc;
            border-radius: 0 6px 6px 0;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .chart-block img { width: 100%; height: auto; display: block; }

        .no-chart {
            height: 80px;
            text-align: center;
            line-height: 80px;
            color: #9ca3af;
            font-size: 11px;
            background: #f9fafb;
            border-radius: 6px;
            border: 1px dashed #d1d5db;
        }

        /* ===================== TX TABLE ===================== */
        .tx-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .tx-table thead tr { background: #1e3a8a; color: #fff; }
        .tx-table th { padding: 8px 9px; font-size: 9.5px; font-weight: bold; text-align: left; text-transform: uppercase; letter-spacing: 0.3px; }
        .tx-table td { padding: 7px 9px; font-size: 10.5px; border-bottom: 1px solid #f0f0f0; color: #374151; }
        .tx-table tr:nth-child(even) td { background: #f9fafb; }
        .tx-table tfoot td { background: #1e3a8a !important; color: #ffffff; font-weight: bold; font-size: 11px; padding: 8px 9px; }

        .type-sale    { color: #2563eb; font-weight: bold; }
        .type-income  { color: #16a34a; font-weight: bold; }
        .type-expense { color: #dc2626; font-weight: bold; }
        .tx-right     { text-align: right; font-weight: bold; }

        .no-data {
            text-align: center;
            padding: 16px;
            color: #9ca3af;
            font-size: 11px;
            border: 1px dashed #d1d5db;
            border-radius: 8px;
        }

        /* ===================== FOOTER ===================== */
        .doc-footer {
            margin-top: 28px;
            padding: 14px 18px;
            border-top: 2px solid #dbeafe;
            text-align: center;
        }

        .footer-brand { font-size: 11px; font-weight: bold; color: #1e3a8a; letter-spacing: 1px; text-transform: uppercase; }
        .footer-desc  { font-size: 9.5px; color: #6b7280; margin-top: 4px; line-height: 1.7; }
        .footer-copy  { font-size: 9px; color: #9ca3af; margin-top: 5px; font-style: italic; }
    </style>
</head>
<body>

{{-- ======================== PAGE 1 ======================== --}}

{{-- COVER HEADER --}}
<div class="cover-header">

    {{-- Top bar: Logo + Brand Name --}}
    <div class="cover-top-bar">
        <div class="cover-top-inner">
            <div class="cover-logo-cell">
                @if(file_exists($logoPath))
                    <div class="logo-box">
                        <img src="{{ $logoPath }}" alt="VendWise Logo">
                    </div>
                @else
                    <div class="logo-fallback-box">V</div>
                @endif
            </div>
            <div class="cover-brand-cell">
                <div class="brand-name">VendWise</div>
                <div class="brand-sub">Financial Tracking &amp; Inventory Management</div>
            </div>
        </div>
    </div>

    {{-- Info bar: Report details --}}
    <div class="cover-info-bar">
        <div class="cover-info-table">
            <div class="cover-info-left">
                <div class="report-main-title">{{ $period }} Profit &amp; Loss Report</div>
                <div class="info-rows">
                    <div class="info-row">
                        <span class="info-row-label">Business Name</span>
                        <span class="info-row-val">{{ $businessName }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-row-label">Report Type</span>
                        <span class="info-row-val">{{ $period }} Report</span>
                    </div>
                    <div class="info-row">
                        <span class="info-row-label">Report Range</span>
                        <span class="info-row-val">{{ $reportRange }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-row-label">Generated On</span>
                        <span class="info-row-val">{{ $generatedAt }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-row-label">System</span>
                        <span class="info-row-val">VendWise</span>
                    </div>
                </div>
                <div class="info-note">
                    Generated On means the date and time this PDF was exported.
                    It is different from the transaction dates inside the report.
                </div>
            </div>
            <div class="cover-info-right">
                <div class="period-badge">{{ strtoupper($period) }} REPORT</div>
                <div class="cover-right-desc">
                    Financial tracking and inventory<br>
                    management report for vendor<br>
                    business review.<br><br>
                    &copy; {{ date('Y') }} VendWise
                </div>
            </div>
        </div>
    </div>

</div>

{{-- FINANCIAL SUMMARY --}}
<div class="section-title">Financial Summary</div>
<div class="summary-table">
    <div class="summary-row">
        <div class="s-card c-sales">
            <div class="s-label">Total Sales</div>
            <div class="s-value col-blue">RM{{ number_format($summary['total_sales'], 2) }}</div>
            <div class="s-sub">Product sales recorded</div>
        </div>
        <div class="s-card c-income">
            <div class="s-label">Other Income</div>
            <div class="s-value col-green">RM{{ number_format($summary['total_income'], 2) }}</div>
            <div class="s-sub">Non-product income</div>
        </div>
        <div class="s-card c-expense">
            <div class="s-label">Total Expenses</div>
            <div class="s-value col-red">RM{{ number_format($summary['total_expenses'], 2) }}</div>
            <div class="s-sub">All expenses recorded</div>
        </div>
        <div class="s-card {{ $summary['net_profit'] >= 0 ? 'c-profit' : 'c-loss' }}">
            <div class="s-label">Net Profit</div>
            <div class="s-value {{ $summary['net_profit'] >= 0 ? 'col-emerald' : 'col-red' }}">
                RM{{ number_format($summary['net_profit'], 2) }}
            </div>
            <div class="s-sub">Revenue minus expenses</div>
        </div>
    </div>
</div>

{{-- BUSINESS PERFORMANCE RATIOS --}}
@php
    $profitMargin = $profitMargin ?? 0;
    $expenseRatio = $expenseRatio ?? 0;
    $pmBadge = $profitMargin >= 15 ? 'badge-green'  : ($profitMargin >= 5 ? 'badge-orange' : 'badge-red');
    $pmLabel = $profitMargin >= 15 ? 'Healthy'      : ($profitMargin >= 5 ? 'Moderate'     : 'Low');
    $erBadge = $expenseRatio >= 90 ? 'badge-red'    : ($expenseRatio >= 75 ? 'badge-orange' : 'badge-blue');
    $erLabel = $expenseRatio >= 90 ? 'Very High'    : ($expenseRatio >= 75 ? 'High'         : 'Controlled');
@endphp

<div class="section-title">Business Performance Ratios</div>
<table class="std-table">
    <thead>
        <tr>
            <th>Ratio</th>
            <th>Value</th>
            <th>Status</th>
            <th>Meaning</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Profit Margin</strong></td>
            <td><strong>{{ number_format($profitMargin, 2) }}%</strong></td>
            <td><span class="badge {{ $pmBadge }}">{{ $pmLabel }}</span></td>
            <td>Shows how much profit is made from total revenue.</td>
        </tr>
        <tr>
            <td><strong>Expense Ratio</strong></td>
            <td><strong>{{ number_format($expenseRatio, 2) }}%</strong></td>
            <td><span class="badge {{ $erBadge }}">{{ $erLabel }}</span></td>
            <td>Shows how much revenue is used to cover expenses.</td>
        </tr>
    </tbody>
</table>

{{-- SMART SUGGESTIONS --}}
<div class="section-title">Smart Business Suggestions</div>
@forelse($smartSuggestions as $suggestion)
    @php
        $stype = $suggestion['type'] ?? 'warning';
        $sbadgeClass = match($stype) { 'success' => 'good', 'danger' => 'critical', default => 'attention' };
        $sbadgeLabel = match($stype) { 'success' => 'Good', 'danger' => 'Critical', default => 'Attention' };
    @endphp
    <div class="suggestion {{ $stype }}">
        <div class="sug-top">
            <span class="sug-title-cell">{{ $suggestion['title'] }}</span>
            <span class="sug-badge-cell">
                <span class="sug-badge {{ $sbadgeClass }}">{{ $sbadgeLabel }}</span>
            </span>
        </div>
        <div class="sug-msg">{{ $suggestion['message'] }}</div>
    </div>
@empty
    <div class="no-data">No suggestions available for this period.</div>
@endforelse

{{-- ======================== PAGE 2 ======================== --}}
<div class="page-break"></div>

{{-- FINANCIAL DETAILS --}}
<div class="section-title">Financial Details</div>

<p style="font-size:10px; font-weight:bold; color:#374151; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Profit Performance</p>
@php
    $bestProfit    = count($profitData) > 0 ? max($profitData) : 0;
    $worstProfit   = count($profitData) > 0 ? min($profitData) : 0;
    $averageProfit = count($profitData) > 0 ? array_sum($profitData) / count($profitData) : 0;
@endphp
<div class="cards-table">
    <div class="cards-row">
        <div class="perf-card">
            <div class="p-label">Best Profit Period</div>
            <div class="p-value col-emerald">RM{{ number_format($bestProfit, 2) }}</div>
        </div>
        <div class="perf-card">
            <div class="p-label">Worst Profit Period</div>
            <div class="p-value col-red">RM{{ number_format($worstProfit, 2) }}</div>
        </div>
        <div class="perf-card">
            <div class="p-label">Average Profit</div>
            <div class="p-value col-blue">RM{{ number_format($averageProfit, 2) }}</div>
        </div>
    </div>
</div>

<p style="font-size:10px; font-weight:bold; color:#374151; margin: 14px 0 8px 0; text-transform:uppercase; letter-spacing:0.5px;">Financial Distribution</p>
<div class="cards-table">
    <div class="cards-row">
        <div class="dist-card">
            <div class="d-label"><span class="dot dot-blue"></span>Sales</div>
            <div class="d-value col-blue">RM{{ number_format($distribution['sales'] ?? 0, 2) }}</div>
        </div>
        <div class="dist-card">
            <div class="d-label"><span class="dot dot-green"></span>Other Income</div>
            <div class="d-value col-green">RM{{ number_format($distribution['other_income'] ?? 0, 2) }}</div>
        </div>
        <div class="dist-card">
            <div class="d-label"><span class="dot dot-red"></span>Expenses</div>
            <div class="d-value col-red">RM{{ number_format($distribution['expenses'] ?? 0, 2) }}</div>
        </div>
    </div>
</div>

<p style="font-size:10px; font-weight:bold; color:#374151; margin: 14px 0 8px 0; text-transform:uppercase; letter-spacing:0.5px;">Report Trend</p>
<table class="trend-table">
    <thead>
        <tr>
            <th>Period</th>
            <th style="text-align:right;">Sales</th>
            <th style="text-align:right;">Other Income</th>
            <th style="text-align:right;">Expenses</th>
            <th style="text-align:right;">Net Profit</th>
        </tr>
    </thead>
    <tbody>
        @forelse($trendLabels as $i => $label)
        <tr>
            <td>{{ $label }}</td>
            <td style="text-align:right;">RM{{ number_format($salesData[$i] ?? 0, 2) }}</td>
            <td style="text-align:right;">RM{{ number_format($incomeData[$i] ?? 0, 2) }}</td>
            <td style="text-align:right;">RM{{ number_format($expensesData[$i] ?? 0, 2) }}</td>
            <td style="text-align:right; font-weight:bold; color:{{ ($profitData[$i] ?? 0) >= 0 ? '#059669' : '#dc2626' }}">
                RM{{ number_format($profitData[$i] ?? 0, 2) }}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center; color:#9ca3af; padding:12px;">
                No trend data available for this period.
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td><strong>Total</strong></td>
            <td style="text-align:right;">RM{{ number_format($summary['total_sales'], 2) }}</td>
            <td style="text-align:right;">RM{{ number_format($summary['total_income'], 2) }}</td>
            <td style="text-align:right;">RM{{ number_format($summary['total_expenses'], 2) }}</td>
            <td style="text-align:right; color:{{ $summary['net_profit'] >= 0 ? '#059669' : '#dc2626' }}; font-weight:bold;">
                RM{{ number_format($summary['net_profit'], 2) }}
            </td>
        </tr>
    </tfoot>
</table>

{{-- ======================== PAGE 3 — CHARTS ======================== --}}
<div class="page-break"></div>

<div class="charts-header">
    <h2>Visual Business Summary</h2>
    <p>These charts help vendors understand business performance faster by comparing sales, expenses, income distribution, and profit movement.</p>
</div>

@php
    $maxSales      = count($salesData) > 0    ? max($salesData)    : 0;
    $lastLabel     = count($trendLabels) > 0  ? end($trendLabels)  : '-';
    $lastSales     = count($salesData) > 0    ? end($salesData)    : 0;
    $lastIncome    = count($incomeData) > 0   ? end($incomeData)   : 0;
    $lastExp       = count($expensesData) > 0 ? end($expensesData) : 0;
    $lastProfit    = count($profitData) > 0   ? end($profitData)   : 0;

    $maxSalesLabel = '-';
    if (count($salesData) > 0) {
        $maxIdx        = array_search(max($salesData), $salesData);
        $maxSalesLabel = $trendLabels[$maxIdx] ?? '-';
    }

    $distMaxLabel = 'Sales';
    $distMaxVal   = $distribution['sales'] ?? 0;
    if (($distribution['other_income'] ?? 0) > $distMaxVal) { $distMaxLabel = 'Other Income'; $distMaxVal = $distribution['other_income']; }
    if (($distribution['expenses']     ?? 0) > $distMaxVal) { $distMaxLabel = 'Expenses';     $distMaxVal = $distribution['expenses']; }
@endphp

<div class="chart-block">
    <div class="chart-block-title">Sales vs Expenses</div>
    <div class="chart-desc">
        This chart compares product sales with business expenses across the selected period.
        @if($maxSales > 0)
            The highest sales value is RM{{ number_format($maxSales, 2) }} in {{ $maxSalesLabel }}.
            In the latest period shown, sales were RM{{ number_format($lastSales, 2) }},
            other income was RM{{ number_format($lastIncome, 2) }},
            and expenses were RM{{ number_format($lastExp, 2) }}.
        @else
            No sales data available for this period.
        @endif
    </div>
    @if(!empty($salesExpenseChart))
        <img src="{{ $salesExpenseChart }}" alt="Sales vs Expenses Chart">
    @else
        <div class="no-chart">No chart data available</div>
    @endif
</div>

<div class="chart-block">
    <div class="chart-block-title">Financial Distribution</div>
    <div class="chart-desc">
        This chart shows how sales, other income, and expenses are distributed in the report.
        @if($distMaxVal > 0)
            The largest amount is {{ $distMaxLabel }} at RM{{ number_format($distMaxVal, 2) }}.
            This helps the vendor understand which financial area has the biggest impact.
        @else
            No distribution data available for this period.
        @endif
    </div>
    @if(!empty($distributionChart))
        <img src="{{ $distributionChart }}" alt="Financial Distribution Chart">
    @else
        <div class="no-chart">No chart data available</div>
    @endif
</div>

<div class="chart-block">
    <div class="chart-block-title">Net Profit Trend</div>
    <div class="chart-desc">
        This chart shows the movement of net profit over time.
        @if(count($profitData) > 0)
            The best profit period recorded RM{{ number_format($bestProfit, 2) }},
            while the worst profit period recorded RM{{ number_format($worstProfit, 2) }}.
            The latest period shown is {{ $lastLabel }} with net profit of RM{{ number_format($lastProfit, 2) }}.
        @else
            No profit trend data available for this period.
        @endif
    </div>
    @if(!empty($profitChart))
        <img src="{{ $profitChart }}" alt="Net Profit Trend Chart">
    @else
        <div class="no-chart">No chart data available</div>
    @endif
</div>

{{-- ======================== PAGE 4 — TRANSACTIONS ======================== --}}
<div class="page-break"></div>

<div class="section-title">Transaction Details</div>

@if($transactions->isEmpty())
    <div class="no-data">No transactions found for this {{ $period }} period.</div>
@else
    <table class="tx-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Type</th>
                <th>Item / Category</th>
                <th>Description</th>
                <th>Payment</th>
                <th style="text-align:right;">Amount (RM)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $i => $tx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
                <td class="type-{{ $tx->type }}">{{ ucfirst($tx->type) }}</td>
                <td>{{ $tx->item ?? '-' }}</td>
                <td>{{ $tx->description ?? '-' }}</td>
                <td>{{ ucfirst($tx->payment ?? '-') }}</td>
                <td class="tx-right">{{ number_format($tx->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align:right;">Net Profit for {{ $period }} Period</td>
                <td style="text-align:right;">RM{{ number_format($summary['net_profit'], 2) }}</td>
            </tr>
        </tfoot>
    </table>
@endif

{{-- DOCUMENT FOOTER --}}
<div class="doc-footer">
    <div class="footer-brand">VendWise Financial Tracking and Inventory Management System</div>
    <div class="footer-desc">
        This report is generated for business review purposes only and is not a replacement for professional accounting, tax, or financial advice.<br>
        VendWise is a Final Year Project system designed to support small vendor financial and inventory management.
    </div>
    <div class="footer-copy">
        &copy; {{ date('Y') }} VendWise &nbsp;|&nbsp; {{ $businessName }} &nbsp;|&nbsp;
        {{ $period }} Report &nbsp;|&nbsp; {{ $reportRange }} &nbsp;|&nbsp; Generated: {{ $generatedAt }}
    </div>
</div>

</body>
</html>