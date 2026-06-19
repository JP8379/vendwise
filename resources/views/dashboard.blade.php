<x-app-layout>

    @php
        $monthLabels      = $monthLabels      ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        $monthlyIncome    = $monthlyIncome    ?? [0, 0, 0, 0, 0, 0];
        $monthlyExpenses  = $monthlyExpenses  ?? [0, 0, 0, 0, 0, 0];
        $monthlyProfit    = $monthlyProfit    ?? [0, 0, 0, 0, 0, 0];
        $smartSuggestions = $smartSuggestions ?? [];
        $isNewUser        = $isNewUser        ?? false;
        $hasPartialData   = $hasPartialData   ?? false;
    @endphp

    <div class="flex min-h-screen" style="background: linear-gradient(160deg, #eef4ff 0%, #f0f4ff 40%, #f8faff 100%);">

        {{-- Sidebar (hidden on mobile, shown on lg+) --}}
        <x-sidebar />

        {{-- Mobile overlay --}}
        <div id="sidebarOverlay"
             class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden"
             onclick="closeSidebar()"></div>

        <main class="flex-1 min-w-0">

            {{-- ══════════════════════════════════════════
                 TOP HEADER — mobile hamburger + desktop header
            ══════════════════════════════════════════ --}}
            <header class="bg-white border-b border-gray-200 px-4 sm:px-8 py-4 flex items-center justify-between gap-4">

                {{-- Mobile: hamburger button --}}
                <button id="sidebarToggle"
                        class="lg:hidden flex flex-col justify-center items-center w-9 h-9 gap-1.5 rounded-lg hover:bg-gray-100 transition shrink-0"
                        onclick="openSidebar()">
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                </button>

                <div class="flex-1 min-w-0">
                    <h2 class="text-xl sm:text-3xl font-bold text-gray-900 truncate">Dashboard</h2>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5 hidden sm:block">Welcome back! Here's your business overview</p>
                </div>

                <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ auth()->user()->name ?? 'User' }}</span>
                </div>
            </header>

            <div class="p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-8">

                {{-- ══ BANNER 1: NEW USER ══ --}}
                @if($isNewUser)
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-5 sm:p-7 shadow-md text-white">
                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold mb-2">
                                    Welcome to VendWise, {{ auth()->user()->name }} 👋
                                </h3>
                                <p class="text-blue-100 mb-3 text-sm sm:text-base">
                                    Your account is ready. Let's set up your business in 3 easy steps.
                                </p>
                                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 mt-3">
                                    <div class="flex items-center gap-2 bg-white/15 rounded-xl px-3 py-2 text-sm font-medium">
                                        <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-white text-blue-600 flex items-center justify-center text-xs font-bold shrink-0">1</span>
                                        Add your product to inventory
                                    </div>
                                    <div class="flex items-center gap-2 bg-white/15 rounded-xl px-3 py-2 text-sm font-medium">
                                        <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-white text-blue-600 flex items-center justify-center text-xs font-bold shrink-0">2</span>
                                        Add your first transaction
                                    </div>
                                    <div class="flex items-center gap-2 bg-white/15 rounded-xl px-3 py-2 text-sm font-medium">
                                        <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-white text-blue-600 flex items-center justify-center text-xs font-bold shrink-0">3</span>
                                        View your reports
                                    </div>
                                </div>
                                <p class="text-xs text-blue-200 mt-3">💡 Tip: Add your income and expenses daily to get better insights.</p>
                            </div>
                            <div class="flex flex-row sm:flex-col gap-2 sm:gap-3 shrink-0">
                                <a href="{{ route('transactions.create') }}"
                                   class="flex-1 sm:flex-none px-4 py-2.5 sm:px-5 sm:py-3 bg-white text-blue-600 rounded-xl font-semibold hover:bg-blue-50 transition text-center shadow text-sm">
                                    Add Transaction
                                </a>
                                <a href="{{ route('inventory.create') }}"
                                   class="flex-1 sm:flex-none px-4 py-2.5 sm:px-5 sm:py-3 bg-white/20 border border-white/40 text-white rounded-xl font-semibold hover:bg-white/30 transition text-center text-sm">
                                    Add Product
                                </a>
                                <a href="{{ route('reports.index') }}"
                                   class="flex-1 sm:flex-none px-4 py-2.5 sm:px-5 sm:py-3 bg-white/10 border border-white/30 text-white rounded-xl font-semibold hover:bg-white/20 transition text-center text-sm">
                                    View Reports
                                </a>
                            </div>
                        </div>
                    </div>

                {{-- ══ BANNER 2: PARTIAL DATA ══ --}}
                @elseif($hasPartialData)
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                        <div class="flex items-start gap-3">
                            <span class="text-xl sm:text-2xl">💡</span>
                            <div>
                                <p class="font-semibold text-blue-800 text-sm">Complete your setup</p>
                                @if(($totalTransactions ?? 0) === 0)
                                    <p class="text-sm text-blue-600 mt-0.5">You have products added. Now add your first transaction to start tracking profit.</p>
                                @else
                                    <p class="text-sm text-blue-600 mt-0.5">You have transactions recorded. Add products to track inventory and stock levels.</p>
                                @endif
                            </div>
                        </div>
                        <div class="shrink-0">
                            @if(($totalTransactions ?? 0) === 0)
                                <a href="{{ route('transactions.create') }}" class="block w-full sm:w-auto text-center px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition">Add Transaction</a>
                            @else
                                <a href="{{ route('inventory.create') }}" class="block w-full sm:w-auto text-center px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition">Add Product</a>
                            @endif
                        </div>
                    </div>

                {{-- ══ BANNER 3: ACTIVE USER ══ --}}
                @else
                    <div class="bg-white border border-gray-200 rounded-2xl px-4 sm:px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 shadow-sm">
                        <div>
                            <p class="font-semibold text-gray-800">Hello, {{ auth()->user()->name }} 👋</p>
                            <p class="text-sm text-gray-500 mt-0.5">Here's a quick summary of your business today.</p>
                        </div>
                        <div class="flex flex-wrap gap-2 sm:gap-3">
                            <a href="{{ route('transactions.create') }}" class="px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-xl text-xs sm:text-sm font-semibold hover:bg-blue-700 transition">+ Add Transaction</a>
                            <a href="{{ route('inventory.create') }}"   class="px-3 sm:px-4 py-2 bg-green-600 text-white rounded-xl text-xs sm:text-sm font-semibold hover:bg-green-700 transition">+ Add Product</a>
                            <a href="{{ route('reports.index') }}"      class="px-3 sm:px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-xl text-xs sm:text-sm font-semibold hover:bg-gray-50 transition">View Reports</a>
                        </div>
                    </div>
                @endif

                {{-- ══ SUMMARY CARDS ══ --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">Total Income</p>
                        <h3 class="text-xl sm:text-3xl font-bold text-green-600">RM {{ number_format($totalIncome ?? 0, 2) }}</h3>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">Total Sales</p>
                        <h3 class="text-xl sm:text-3xl font-bold text-blue-600">RM {{ number_format($totalSales ?? 0, 2) }}</h3>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">Total Expenses</p>
                        <h3 class="text-xl sm:text-3xl font-bold text-red-600">RM {{ number_format($totalExpenses ?? 0, 2) }}</h3>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">Profit / Loss</p>
                        <h3 class="text-xl sm:text-3xl font-bold {{ ($profit ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            RM {{ number_format($profit ?? 0, 2) }}
                        </h3>
                    </div>
                </div>

                {{-- ══ SMART SUGGESTIONS ══ --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4 sm:mb-5">
                        <div>
                            <h3 class="text-base sm:text-xl font-bold text-gray-900">AI Business Suggestions</h3>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1">Smart insights based on your sales, expenses, profit, and inventory activity.</p>
                        </div>
                        <span class="self-start sm:self-auto px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-blue-50 text-blue-700 text-xs sm:text-sm font-semibold whitespace-nowrap">
                            Smart Insights
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-4">
                        @forelse($smartSuggestions as $suggestion)
                            <div class="rounded-2xl border p-4 sm:p-5
                                @if($suggestion['type'] === 'success') bg-green-50 border-green-200
                                @elseif($suggestion['type'] === 'danger') bg-red-50 border-red-200
                                @else bg-yellow-50 border-yellow-200 @endif">
                                <div class="text-xl sm:text-2xl mb-2 sm:mb-3">{{ $suggestion['icon'] ?? '💡' }}</div>
                                <h4 class="font-bold text-sm sm:text-base
                                    @if($suggestion['type'] === 'success') text-green-800
                                    @elseif($suggestion['type'] === 'danger') text-red-800
                                    @else text-yellow-800 @endif">
                                    {{ $suggestion['title'] }}
                                </h4>
                                <p class="text-xs sm:text-sm text-gray-700 mt-1.5 sm:mt-2">{{ $suggestion['message'] }}</p>
                            </div>
                        @empty
                            <div class="col-span-full rounded-2xl bg-gray-50 border border-gray-200 p-5 sm:p-6 text-gray-500 text-sm">
                                No suggestions available yet. Add more transactions to generate insights.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ══ QUICK STATS ══ --}}
                <div class="grid grid-cols-2 gap-3 sm:gap-6">
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">Total Transactions</p>
                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalTransactions ?? 0 }}</h3>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2">Low Stock Items</p>
                        <h3 class="text-2xl sm:text-3xl font-bold {{ ($lowStockCount ?? 0) > 0 ? 'text-yellow-600' : 'text-green-600' }}">
                            {{ $lowStockCount ?? 0 }}
                        </h3>
                    </div>
                </div>

                {{-- ══ CHARTS ══ --}}
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6">
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Income vs Expenses</h3>
                        <div class="h-56 sm:h-80">
                            <canvas id="incomeExpenseChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Monthly Profit Trend</h3>
                        <div class="h-56 sm:h-80">
                            <canvas id="profitTrendChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- ══ RECENT TRANSACTIONS ══ --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4 sm:mb-5">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">Recent Transactions</h3>
                        <a href="{{ route('transactions.index') }}" class="text-blue-600 text-xs sm:text-sm font-medium hover:underline">View All</a>
                    </div>
                    <div class="overflow-x-auto -mx-4 sm:mx-0">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 text-left">
                                    <th class="py-3 px-4 sm:px-0 sm:pr-4 text-xs sm:text-sm font-semibold text-gray-500">Date</th>
                                    <th class="py-3 pr-4 text-xs sm:text-sm font-semibold text-gray-500">Type</th>
                                    <th class="py-3 pr-4 text-xs sm:text-sm font-semibold text-gray-500 hidden sm:table-cell">Category</th>
                                    <th class="py-3 pr-4 text-xs sm:text-sm font-semibold text-gray-500">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions ?? [] as $transaction)
                                    @php
                                        $type = strtolower($transaction->type);
                                        $isPositive = in_array($type, ['income', 'sale']);
                                    @endphp
                                    <tr class="border-b border-gray-100">
                                        <td class="py-3 px-4 sm:px-0 sm:pr-4 text-xs sm:text-sm text-gray-700">
                                            {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 pr-4">
                                            <span class="text-xs sm:text-sm font-medium {{ $isPositive ? 'text-green-600' : 'text-red-600' }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td class="py-3 pr-4 text-xs sm:text-sm text-gray-700 hidden sm:table-cell">
                                            {{ $transaction->category ?? '-' }}
                                        </td>
                                        <td class="py-3 pr-4 text-xs sm:text-sm font-semibold {{ $isPositive ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $isPositive ? '+' : '-' }} RM {{ number_format($transaction->amount, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-sm text-gray-500">No transactions yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ── Sidebar open/close for mobile ──
        function openSidebar() {
            document.getElementById('mobileSidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.remove('hidden');
        }
        function closeSidebar() {
            document.getElementById('mobileSidebar').classList.add('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }

        // ── Charts ──
        const monthLabels     = @json($monthLabels);
        const monthlyIncome   = @json($monthlyIncome);
        const monthlyExpenses = @json($monthlyExpenses);
        const monthlyProfit   = @json($monthlyProfit);

        const incomeExpenseCtx = document.getElementById('incomeExpenseChart');
        if (incomeExpenseCtx) {
            new Chart(incomeExpenseCtx, {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [
                        { label: 'Income + Sales', data: monthlyIncome,   backgroundColor: '#3b82f6', borderRadius: 8 },
                        { label: 'Expenses',       data: monthlyExpenses, backgroundColor: '#ef4444', borderRadius: 8 }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { labels: { font: { size: 11 } } } }
                }
            });
        }

        const profitTrendCtx = document.getElementById('profitTrendChart');
        if (profitTrendCtx) {
            new Chart(profitTrendCtx, {
                type: 'line',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: 'Profit',
                        data: monthlyProfit,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16,185,129,0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { labels: { font: { size: 11 } } } }
                }
            });
        }
    </script>

</x-app-layout>