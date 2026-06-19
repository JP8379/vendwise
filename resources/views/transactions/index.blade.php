<x-app-layout>
    @php
        $totalIncoming = $transactions->whereIn('type', ['income', 'sale'])->sum('amount');
        $totalExpense  = $transactions->where('type', 'expense')->sum('amount');
        $netBalance    = $totalIncoming - $totalExpense;
    @endphp

    <div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100">
        <x-sidebar />
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

        <main class="flex-1 min-w-0">

            {{-- Mobile header --}}
            <header class="bg-white border-b border-gray-200 px-4 sm:px-8 py-4 flex items-center justify-between gap-4">
                <button class="lg:hidden flex flex-col justify-center items-center w-9 h-9 gap-1.5 rounded-lg hover:bg-gray-100 transition" onclick="openSidebar()">
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                </button>
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-3xl font-bold text-slate-800 truncate">Transactions</h1>
                    <p class="text-xs sm:text-sm text-slate-600 mt-0.5 hidden sm:block">View and manage your income, expenses, and sales</p>
                </div>
                <a href="{{ route('transactions.create') }}"
                   class="shrink-0 px-3 sm:px-5 py-2 sm:py-2.5 bg-blue-600 text-white rounded-xl text-xs sm:text-sm font-semibold shadow hover:bg-blue-700 transition">
                    + Add
                </a>
            </header>

            <div class="p-4 sm:p-6 lg:p-8 space-y-5 sm:space-y-6">

                {{-- Summary Cards --}}
                <div class="grid grid-cols-3 gap-3 sm:gap-4">
                    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm border border-white/70 p-3 sm:p-5">
                        <p class="text-xs sm:text-sm text-slate-500">Total Incoming</p>
                        <h2 class="text-base sm:text-2xl font-bold text-green-600 mt-1 sm:mt-2">RM{{ number_format($totalIncoming, 2) }}</h2>
                        <p class="text-xs text-slate-400 mt-1 hidden sm:block">Income + Sales</p>
                    </div>
                    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm border border-white/70 p-3 sm:p-5">
                        <p class="text-xs sm:text-sm text-slate-500">Total Expense</p>
                        <h2 class="text-base sm:text-2xl font-bold text-red-500 mt-1 sm:mt-2">RM{{ number_format($totalExpense, 2) }}</h2>
                        <p class="text-xs text-slate-400 mt-1 hidden sm:block">All expense transactions</p>
                    </div>
                    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm border border-white/70 p-3 sm:p-5">
                        <p class="text-xs sm:text-sm text-slate-500">Net Balance</p>
                        <h2 class="text-base sm:text-2xl font-bold mt-1 sm:mt-2 {{ $netBalance >= 0 ? 'text-blue-600' : 'text-red-500' }}">RM{{ number_format($netBalance, 2) }}</h2>
                        <p class="text-xs text-slate-400 mt-1 hidden sm:block">Incoming - Expense</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>
                @endif

                {{-- Search / Filter --}}
                <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm border border-white/70 p-4 sm:p-5">
                    <form method="GET" action="{{ route('transactions.index') }}">
                        <div class="flex flex-col gap-3 sm:grid sm:grid-cols-12 sm:gap-4 sm:items-end">
                            <div class="sm:col-span-5">
                                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1.5">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search category, description..."
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1.5">Type</label>
                                <select name="type" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="all"     {{ !request('type') || request('type') == 'all'     ? 'selected' : '' }}>All</option>
                                    <option value="income"  {{ request('type') == 'income'  ? 'selected' : '' }}>Income</option>
                                    <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                                    <option value="sale"    {{ request('type') == 'sale'    ? 'selected' : '' }}>Sale</option>
                                </select>
                            </div>
                            <div class="sm:col-span-3 flex gap-2">
                                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition text-sm">Filter</button>
                                <a href="{{ route('transactions.index') }}" class="flex-1 text-center px-4 py-2.5 bg-slate-200 text-slate-700 rounded-xl font-medium hover:bg-slate-300 transition text-sm">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Transactions Table --}}
                <div class="bg-white/90 backdrop-blur rounded-2xl shadow-sm border border-white/70 overflow-hidden">
                    @if($transactions->isEmpty())
                        <div class="py-12 text-center">
                            <p class="text-slate-500 font-medium">No transactions found.</p>
                            <p class="text-slate-400 text-sm mt-1">Try adding a transaction or adjusting your filter.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-50 border-b border-slate-200">
                                    <tr>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-slate-600 text-xs sm:text-sm">Type</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-slate-600 text-xs sm:text-sm">Item / Category</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-slate-600 text-xs sm:text-sm hidden md:table-cell">Description</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-slate-600 text-xs sm:text-sm hidden sm:table-cell">Payment</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-slate-600 text-xs sm:text-sm">Date</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-right font-semibold text-slate-600 text-xs sm:text-sm">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($transactions as $transaction)
                                        @php
                                            $isRestock = $transaction->type === 'expense'
                                                && $transaction->category === 'Stock Purchase / Restock'
                                                && $transaction->product;
                                        @endphp
                                        <tr class="hover:bg-blue-50/40 transition">
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 align-top">
                                                @if($transaction->type === 'income')
                                                    <span class="inline-flex px-2 sm:px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Income</span>
                                                @elseif($transaction->type === 'expense')
                                                    <span class="inline-flex px-2 sm:px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Expense</span>
                                                @else
                                                    <span class="inline-flex px-2 sm:px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Sale</span>
                                                @endif
                                            </td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 align-top">
                                                @if($transaction->type === 'sale' && $transaction->product)
                                                    <div class="font-semibold text-slate-800 text-xs sm:text-sm">
                                                        {{ $transaction->product->name }}
                                                        @if($transaction->quantity)
                                                            <span class="text-slate-500 text-xs">(x{{ $transaction->quantity }})</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-slate-400 mt-0.5">{{ $transaction->category }}</div>
                                                @elseif($isRestock)
                                                    <div class="font-semibold text-slate-800 text-xs sm:text-sm">
                                                        {{ $transaction->product->name }} Restock
                                                        @if($transaction->quantity)
                                                            <span class="text-slate-500 text-xs">(x{{ $transaction->quantity }})</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-slate-400 mt-0.5">{{ $transaction->category }}</div>
                                                @else
                                                    <div class="font-semibold text-slate-800 text-xs sm:text-sm">{{ $transaction->category }}</div>
                                                @endif
                                            </td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 align-top text-slate-600 text-xs sm:text-sm hidden md:table-cell">{{ $transaction->description ?: '-' }}</td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 align-top hidden sm:table-cell">
                                                <span class="inline-flex px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">{{ $transaction->payment_method }}</span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 align-top text-slate-600 whitespace-nowrap text-xs sm:text-sm">
                                                {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 align-top text-right whitespace-nowrap">
                                                @if($transaction->type === 'expense')
                                                    <span class="font-bold text-red-600 text-xs sm:text-base">- RM {{ number_format($transaction->amount, 2) }}</span>
                                                @else
                                                    <span class="font-bold text-green-600 text-xs sm:text-base">+ RM {{ number_format($transaction->amount, 2) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>
        </main>
    </div>
    <script>
        function openSidebar()  { document.getElementById('mobileSidebar').classList.remove('-translate-x-full'); document.getElementById('sidebarOverlay').classList.remove('hidden'); }
        function closeSidebar() { document.getElementById('mobileSidebar').classList.add('-translate-x-full');    document.getElementById('sidebarOverlay').classList.add('hidden'); }
    </script>
</x-app-layout>