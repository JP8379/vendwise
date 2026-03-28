<x-app-layout>
    <div class="min-h-screen bg-slate-100">
        <div class="mx-auto max-w-7xl px-6 py-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <h1 class="text-5xl font-bold tracking-tight text-slate-900">Profit &amp; Loss Report</h1>
                    <p class="mt-2 text-lg text-slate-600">Comprehensive financial overview</p>
                </div>

                {{-- Period Buttons --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('reports.index', 'daily') }}"
                       class="rounded-xl px-5 py-3 text-sm font-semibold shadow-sm transition
                       {{ $period === 'daily' ? 'bg-blue-500 text-white hover:bg-blue-600' : 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50' }}">
                        Daily
                    </a>

                    <a href="{{ route('reports.index', 'monthly') }}"
                       class="rounded-xl px-5 py-3 text-sm font-semibold shadow-sm transition
                       {{ $period === 'monthly' ? 'bg-blue-500 text-white hover:bg-blue-600' : 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50' }}">
                        Monthly
                    </a>

                    <a href="{{ route('reports.index', 'yearly') }}"
                       class="rounded-xl px-5 py-3 text-sm font-semibold shadow-sm transition
                       {{ $period === 'yearly' ? 'bg-blue-500 text-white hover:bg-blue-600' : 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50' }}">
                        Yearly
                    </a>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="mb-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <p class="text-sm text-slate-500">Total Sales</p>
                    <h2 class="mt-3 text-4xl font-bold text-blue-500">
                        RM{{ number_format($summary['total_sales'], 2) }}
                    </h2>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <p class="text-sm text-slate-500">Total Income</p>
                    <h2 class="mt-3 text-4xl font-bold text-green-500">
                        RM{{ number_format($summary['total_income'], 2) }}
                    </h2>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <p class="text-sm text-slate-500">Total Expenses</p>
                    <h2 class="mt-3 text-4xl font-bold text-red-500">
                        RM{{ number_format($summary['total_expenses'], 2) }}
                    </h2>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
                    <p class="text-sm text-slate-500">Net Profit</p>
                    <h2 class="mt-3 text-4xl font-bold text-slate-900">
                        RM{{ number_format($summary['net_profit'], 2) }}
                    </h2>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid gap-6 lg:grid-cols-2">

                {{-- Line Chart --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Financial Trends</h3>

                    @if(empty($trendLabels) || count($trendLabels) === 0)
                        <div class="flex h-[350px] items-center justify-center text-slate-500">
                            No data available
                        </div>
                    @else
                        <div class="h-[350px]">
                            <canvas id="trendChart"></canvas>
                        </div>
                    @endif
                </div>

                {{-- Pie Chart --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Financial Distribution</h3>

                    @php
                        $distributionTotal = $distribution['sales'] + $distribution['other_income'] + $distribution['expenses'];
                    @endphp

                    @if($distributionTotal <= 0)
                        <div class="flex h-[350px] items-center justify-center text-slate-500">
                            No data available
                        </div>
                    @else
                        <div class="h-[300px]">
                            <canvas id="distributionChart"></canvas>
                        </div>

                        {{-- Legend --}}
                        <div class="mt-5 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="w-3 h-3 bg-blue-500 rounded"></span> Sales
                                </span>
                                <span>RM{{ number_format($distribution['sales'], 2) }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="w-3 h-3 bg-green-500 rounded"></span> Other Income
                                </span>
                                <span>RM{{ number_format($distribution['other_income'], 2) }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="w-3 h-3 bg-red-500 rounded"></span> Expenses
                                </span>
                                <span>RM{{ number_format($distribution['expenses'], 2) }}</span>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if(!empty($trendLabels) && count($trendLabels) > 0)
    <script>
        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: @json($trendLabels),
                datasets: [
                    {
                        label: 'Sales',
                        data: @json($salesData),
                        borderColor: '#3B82F6',
                        tension: 0.4
                    },
                    {
                        label: 'Profit',
                        data: @json($profitData),
                        borderColor: '#22C55E',
                        tension: 0.4
                    },
                    {
                        label: 'Expenses',
                        data: @json($expensesData),
                        borderColor: '#EF4444',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
    @endif

    @if($distributionTotal > 0)
    <script>
        new Chart(document.getElementById('distributionChart'), {
            type: 'pie',
            data: {
                labels: ['Sales', 'Other Income', 'Expenses'],
                datasets: [{
                    data: [
                        {{ $distribution['sales'] }},
                        {{ $distribution['other_income'] }},
                        {{ $distribution['expenses'] }}
                    ],
                    backgroundColor: ['#3B82F6', '#22C55E', '#EF4444']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
    @endif

</x-app-layout>