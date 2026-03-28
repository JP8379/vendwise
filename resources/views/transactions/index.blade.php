<x-app-layout>
    <div class="min-h-screen bg-slate-100">
        <div class="mx-auto max-w-7xl px-6 py-8">
            <div class="mb-8">
                <h1 class="text-5xl font-bold tracking-tight text-slate-900">Transaction History</h1>
                <p class="mt-2 text-lg text-slate-600">View and manage all your transactions</p>
            </div>

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="grid gap-4 lg:grid-cols-12">
                    <div class="lg:col-span-6">
                        <input
                            type="text"
                            placeholder="Search transactions..."
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base focus:border-blue-500 focus:outline-none focus:ring-0"
                        >
                    </div>

                    <div class="lg:col-span-3">
                        <select class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base focus:border-blue-500 focus:outline-none focus:ring-0">
                            <option>All Types</option>
                            <option>Income</option>
                            <option>Expense</option>
                            <option>Sale</option>
                        </select>
                    </div>

                    <div class="lg:col-span-3">
                        <button
                            type="button"
                            class="w-full rounded-xl border border-blue-500 px-4 py-3 text-base font-medium text-blue-600 transition hover:bg-blue-50"
                        >
                            More Filters
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead class="bg-slate-50">
                            <tr class="border-b border-slate-200 text-sm text-slate-600">
                                <th class="px-5 py-4 font-semibold">Date</th>
                                <th class="px-5 py-4 font-semibold">Type</th>
                                <th class="px-5 py-4 font-semibold">Category</th>
                                <th class="px-5 py-4 font-semibold">Amount</th>
                                <th class="px-5 py-4 font-semibold">Notes</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse($transactions as $transaction)
                                <tr class="text-base text-slate-700">
                                    <td class="px-5 py-4">{{ $transaction->date }}</td>

                                    <td class="px-5 py-4">
                                        @php
                                            $type = strtolower($transaction->type);

                                            $badgeClass = match($type) {
                                                'income' => 'bg-green-100 text-green-700',
                                                'expense' => 'bg-red-100 text-red-600',
                                                'sale' => 'bg-blue-100 text-blue-700',
                                                default => 'bg-slate-100 text-slate-700',
                                            };
                                        @endphp

                                        <span class="inline-flex rounded-full px-3 py-1 text-sm font-medium {{ $badgeClass }}">
                                            {{ $transaction->type }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4">{{ $transaction->category }}</td>

                                    <td class="px-5 py-4 font-semibold {{ strtolower($transaction->type) === 'expense' ? 'text-red-500' : 'text-green-600' }}">
                                        {{ strtolower($transaction->type) === 'expense' ? '-' : '+' }}RM{{ number_format($transaction->amount, 2) }}
                                    </td>

                                    <td class="px-5 py-4">{{ $transaction->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                                        No transactions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col items-start justify-between gap-4 border-t border-slate-200 px-5 py-5 text-sm text-slate-600 sm:flex-row sm:items-center">
                    <p>Showing {{ $transactions->count() }} transaction(s)</p>

                    <div class="flex items-center gap-2">
                        <button class="rounded-lg border border-slate-300 px-4 py-2 text-slate-700 hover:bg-slate-50">
                            Previous
                        </button>
                        <button class="rounded-lg bg-blue-600 px-4 py-2 text-white">
                            1
                        </button>
                        <button class="rounded-lg border border-slate-300 px-4 py-2 text-slate-700 hover:bg-slate-50">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>