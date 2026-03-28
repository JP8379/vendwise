<x-app-layout>
    <div class="min-h-screen bg-slate-100">
        <div class="mx-auto max-w-3xl px-6 py-10">

            {{-- Title --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-800">Add Transaction</h1>
                <p class="text-slate-600 mt-2">Record a new income, expense, or sale</p>
            </div>

            <div class="bg-white rounded-2xl shadow border">

                {{-- Tabs --}}
                <div class="grid grid-cols-3 border-b">
                    <button onclick="setType('income')" id="tab-income"
                        class="py-3 font-semibold bg-blue-500 text-white">
                        Income
                    </button>

                    <button onclick="setType('expense')" id="tab-expense"
                        class="py-3 font-semibold text-slate-600">
                        Expense
                    </button>

                    <button onclick="setType('sale')" id="tab-sale"
                        class="py-3 font-semibold text-slate-600">
                        Sale
                    </button>
                </div>

                <div class="p-6">

                    {{-- Success --}}
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <input type="hidden" name="type" id="type" value="income">

                        {{-- Row 1 --}}
                        <div class="grid grid-cols-2 gap-4">

                            {{-- Category --}}
                            <div>
                                <label class="text-sm font-medium">Category</label>
                                <select name="category" id="category"
                                    class="w-full mt-1 border rounded-lg p-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select category</option>
                                </select>
                            </div>

                            {{-- Amount --}}
                            <div>
                                <label class="text-sm font-medium">Amount</label>
                                <input type="number" step="0.01" name="amount" placeholder="0.00"
                                    class="w-full mt-1 border rounded-lg p-2">
                            </div>

                        </div>

                        {{-- Description --}}
                        <div class="mt-4">
                            <label class="text-sm font-medium">Description</label>
                            <input type="text" name="description" placeholder="Enter description"
                                class="w-full mt-1 border rounded-lg p-2">
                        </div>

                        {{-- Row 2 --}}
                        <div class="grid grid-cols-2 gap-4 mt-4">

                            {{-- Payment --}}
                            <div>
                                <label class="text-sm font-medium">Payment Method</label>
                                <select name="payment_method"
                                    class="w-full mt-1 border rounded-lg p-2">
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Online Transfer">Online Transfer</option>
                                    <option value="E-Wallet">E-Wallet</option>
                                </select>
                            </div>

                            {{-- Date --}}
                            <div>
                                <label class="text-sm font-medium">Date</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}"
                                    class="w-full mt-1 border rounded-lg p-2">
                            </div>

                        </div>

                        {{-- Button --}}
                        <button type="submit"
                            class="w-full mt-6 bg-blue-500 text-white py-3 rounded-lg font-semibold hover:bg-blue-600">
                            Save Transaction
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- Script --}}
    <script>
        function setType(type) {
            document.getElementById('type').value = type;

            const category = document.getElementById('category');

            let options = [];

            if (type === 'income') {
                options = ['Product Sale', 'Service', 'Consultation', 'Other'];
            } else if (type === 'expense') {
                options = ['Supplies', 'Utilities', 'Marketing', 'Other'];
            } else {
                options = ['Product Sale', 'Service', 'Other'];
            }

            category.innerHTML = '<option value="">Select category</option>';

            options.forEach(function(opt) {
                category.innerHTML += `<option value="${opt}">${opt}</option>`;
            });

            ['income','expense','sale'].forEach(t => {
                let tab = document.getElementById('tab-' + t);

                if (t === type) {
                    tab.classList.add('bg-blue-500','text-white');
                    tab.classList.remove('text-slate-600');
                } else {
                    tab.classList.remove('bg-blue-500','text-white');
                    tab.classList.add('text-slate-600');
                }
            });
        }

        // Default load
        setType('income');
    </script>
</x-app-layout>