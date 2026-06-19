<x-app-layout>
    <div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100">

        <x-sidebar />

        <main class="flex-1">
            <div class="mx-auto max-w-3xl px-6 py-10">

                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-slate-800">Add Transaction</h1>
                    <p class="text-slate-600 mt-2">Record a new income, expense, or sale</p>
                </div>

                <div class="bg-white/95 backdrop-blur rounded-2xl shadow border border-white/70 overflow-hidden">
                    <div class="grid grid-cols-3 border-b">
                        <button onclick="setType('income')" id="tab-income" type="button"
                            class="py-3 font-semibold bg-blue-600 text-white">
                            Income
                        </button>

                        <button onclick="setType('expense')" id="tab-expense" type="button"
                            class="py-3 font-semibold text-slate-600">
                            Expense
                        </button>

                        <button onclick="setType('sale')" id="tab-sale" type="button"
                            class="py-3 font-semibold text-slate-600">
                            Sale
                        </button>
                    </div>

                    <div class="p-6">

                        @if ($errors->any())
                            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg border border-red-200">
                                <ul class="list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="mb-4 bg-green-100 text-green-700 p-3 rounded-lg border border-green-200">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('transactions.store') }}">
                            @csrf

                            <input type="hidden" name="type" id="type" value="income">
                            <input type="hidden" name="expense_mode" id="expense_mode" value="normal">

                            <!-- Expense Type -->
                            <div id="expenseTypeSection" class="hidden mb-5 bg-slate-50 border border-slate-200 rounded-xl p-4">
                                <label class="text-sm font-semibold text-slate-700">Expense Type</label>

                                <div class="grid grid-cols-2 gap-3 mt-3">
                                    <button type="button" id="normalExpenseBtn"
                                        onclick="setExpenseMode('normal')"
                                        class="expense-mode-btn border rounded-lg px-4 py-3 text-sm font-semibold bg-blue-600 text-white">
                                        Normal Expense
                                    </button>

                                    <button type="button" id="restockExpenseBtn"
                                        onclick="setExpenseMode('restock')"
                                        class="expense-mode-btn border rounded-lg px-4 py-3 text-sm font-semibold bg-white text-slate-700 hover:bg-blue-50">
                                        Stock Purchase / Restock
                                    </button>
                                </div>

                                <p class="text-xs text-slate-500 mt-2">
                                    Normal expenses do not affect inventory. Restock expenses will increase product stock.
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">

                                <!-- Category -->
                                <div class="relative" id="categorySection">
                                    <label class="text-sm font-medium">Category</label>

                                    <input
                                        type="text"
                                        id="category_search"
                                        placeholder="Search category..."
                                        autocomplete="off"
                                        class="w-full mt-1 border rounded-lg p-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >

                                    <input type="hidden" name="category" id="category">

                                    <div id="categoryDropdown"
                                        class="absolute z-20 mt-1 w-full bg-white border border-slate-200 rounded-lg shadow-lg hidden max-h-56 overflow-y-auto">
                                    </div>

                                    <div id="otherCategoryWrapper" class="mt-3 hidden">
                                        <label class="text-sm font-medium">Specify Category</label>
                                        <input
                                            type="text"
                                            name="custom_category"
                                            id="custom_category"
                                            placeholder="Enter your category..."
                                            class="w-full mt-1 border rounded-lg p-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        >
                                    </div>

                                    <p class="text-xs text-slate-500 mt-2">
                                        Search an existing category or choose Other.
                                    </p>
                                </div>

                                <!-- Amount -->
                                <div>
                                    <label class="text-sm font-medium">Amount</label>
                                    <input type="number" step="0.01" name="amount" id="amount" placeholder="0.00"
                                        class="w-full mt-1 border rounded-lg p-2">

                                    <p id="amountHelp" class="text-xs text-slate-500 mt-2 hidden">
                                        Amount is calculated automatically.
                                    </p>
                                </div>

                            </div>

                            <!-- Sale Product Fields -->
                            <div id="saleFields" class="hidden mt-5 bg-blue-50 border border-blue-200 rounded-xl p-4">
                                <h3 class="font-semibold text-slate-800 mb-3">Sale Details</h3>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-medium">Product Sold</label>
                                        <select name="product_id" id="product_id"
                                            class="w-full mt-1 border rounded-lg p-2 bg-white">
                                            <option value="">Select product</option>

                                            @foreach($products as $product)
                                                <option
                                                    value="{{ $product->id }}"
                                                    data-price="{{ $product->price }}"
                                                    data-stock="{{ $product->stock_quantity }}"
                                                    {{ $product->stock_quantity == 0 ? 'disabled' : '' }}
                                                >
                                                    {{ $product->name }}
                                                    | Stock: {{ $product->stock_quantity }}
                                                    | RM {{ number_format($product->price, 2) }}
                                                    {{ $product->stock_quantity == 0 ? '| OUT OF STOCK' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm font-medium">Quantity Sold</label>
                                        <input type="number" name="quantity" id="quantity" min="1"
                                            placeholder="Example: 1"
                                            class="w-full mt-1 border rounded-lg p-2">

                                        <p id="stockWarning" class="text-sm text-red-600 mt-2 hidden"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Restock Fields -->
                            <div id="restockFields" class="hidden mt-5 bg-green-50 border border-green-200 rounded-xl p-4">
                                <h3 class="font-semibold text-slate-800 mb-3">Restock Details</h3>

                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="text-sm font-medium">Product Restocked</label>
                                        <select name="restock_product_id" id="restock_product_id"
                                            class="w-full mt-1 border rounded-lg p-2 bg-white">
                                            <option value="">Select product</option>

                                            @foreach($products as $product)
                                                <option
                                                    value="{{ $product->id }}"
                                                    data-stock="{{ $product->stock_quantity }}"
                                                >
                                                    {{ $product->name }}
                                                    | Current Stock: {{ $product->stock_quantity }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm font-medium">Quantity Added</label>
                                        <input type="number" name="restock_quantity" id="restock_quantity" min="1"
                                            placeholder="Example: 10"
                                            class="w-full mt-1 border rounded-lg p-2">
                                    </div>

                                    <div>
                                        <label class="text-sm font-medium">Unit Cost (RM)</label>
                                        <input type="number" step="0.01" name="unit_cost" id="unit_cost" min="0"
                                            placeholder="Example: 8.00"
                                            class="w-full mt-1 border rounded-lg p-2">
                                    </div>
                                </div>

                                <p class="text-xs text-slate-500 mt-2">
                                    The amount will be calculated from quantity added × unit cost.
                                </p>
                            </div>

                            <div class="mt-4">
                                <label class="text-sm font-medium">Description</label>
                                <input type="text" name="description" placeholder="Optional"
                                    class="w-full mt-1 border rounded-lg p-2">
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="text-sm font-medium">Payment Method</label>
                                    <select name="payment_method" class="w-full mt-1 border rounded-lg p-2">
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="Online Transfer">Online Transfer</option>
                                        <option value="E-Wallet">E-Wallet</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm font-medium">Date</label>
                                    <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                                        max="{{ date('Y-m-d') }}"
                                        class="w-full mt-1 border rounded-lg p-2">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full mt-6 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                                Save Transaction
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        const categoriesByType = {
            income: [
                @if(isset($categories['income']))
                    @foreach($categories['income'] as $category)
                        "{{ $category->name }}",
                    @endforeach
                @endif
                "Service",
                "Consultation"
            ],
            expense: [
                @if(isset($categories['expense']))
                    @foreach($categories['expense'] as $category)
                        "{{ $category->name }}",
                    @endforeach
                @endif
                "Supplies",
                "Utilities",
                "Marketing",
                "Stock Purchase / Restock"
            ],
            sale: [
                @if(isset($categories['sale']))
                    @foreach($categories['sale'] as $category)
                        "{{ $category->name }}",
                    @endforeach
                @endif
                "Product Sale"
            ]
        };

        let currentType = 'income';
        let currentExpenseMode = 'normal';

        function uniqueCategories(list) {
            return [...new Set(list)].sort((a, b) => a.localeCompare(b));
        }

        function showOtherInput(show) {
            const wrapper = document.getElementById('otherCategoryWrapper');
            const customInput = document.getElementById('custom_category');

            if (show) {
                wrapper.classList.remove('hidden');
            } else {
                wrapper.classList.add('hidden');
                customInput.value = '';
            }
        }

        function selectCategory(value) {
            const searchInput = document.getElementById('category_search');
            const hiddenInput = document.getElementById('category');
            const dropdown = document.getElementById('categoryDropdown');

            hiddenInput.value = value;
            searchInput.value = value;
            dropdown.classList.add('hidden');

            showOtherInput(value === 'Other');
        }

        function renderDropdown(filter = '') {
            const dropdown = document.getElementById('categoryDropdown');
            let options = uniqueCategories(categoriesByType[currentType] || []);

            options = options.filter(item => item.toLowerCase() !== 'other');

            if (filter.trim() !== '') {
                options = options.filter(item =>
                    item.toLowerCase().includes(filter.toLowerCase())
                );
            }

            dropdown.innerHTML = '';

            options.forEach(option => {
                const item = document.createElement('button');
                item.type = 'button';
                item.className = 'w-full text-left px-4 py-3 text-sm hover:bg-blue-50 transition';
                item.textContent = option;

                item.addEventListener('click', function () {
                    selectCategory(option);
                });

                dropdown.appendChild(item);
            });

            const otherItem = document.createElement('button');
            otherItem.type = 'button';
            otherItem.className = 'w-full text-left px-4 py-3 text-sm border-t font-medium text-blue-600 hover:bg-blue-50 transition';
            otherItem.textContent = 'Other';

            otherItem.addEventListener('click', function () {
                selectCategory('Other');
            });

            dropdown.appendChild(otherItem);
            dropdown.classList.remove('hidden');
        }

        function calculateSaleAmount() {
            if (currentType !== 'sale') return;

            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const amountInput = document.getElementById('amount');
            const stockWarning = document.getElementById('stockWarning');

            const selectedOption = productSelect.options[productSelect.selectedIndex];

            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const quantity = parseInt(quantityInput.value) || 0;

            stockWarning.classList.add('hidden');
            stockWarning.textContent = '';

            if (quantity > stock) {
                stockWarning.textContent = 'Only ' + stock + ' item(s) available. Please reduce the quantity.';
                stockWarning.classList.remove('hidden');
                amountInput.value = '';
                return;
            }

            if (stock <= 5 && stock > 0) {
                stockWarning.textContent = 'Low stock warning: only ' + stock + ' item(s) available.';
                stockWarning.classList.remove('hidden');
            }

            if (price > 0 && quantity > 0) {
                amountInput.value = (price * quantity).toFixed(2);
            } else {
                amountInput.value = '';
            }
        }

        function calculateRestockAmount() {
            if (currentType !== 'expense' || currentExpenseMode !== 'restock') return;

            const quantity = parseInt(document.getElementById('restock_quantity').value) || 0;
            const unitCost = parseFloat(document.getElementById('unit_cost').value) || 0;
            const amountInput = document.getElementById('amount');

            if (quantity > 0 && unitCost >= 0) {
                amountInput.value = (quantity * unitCost).toFixed(2);
            } else {
                amountInput.value = '';
            }
        }

        function setExpenseMode(mode) {
            currentExpenseMode = mode;
            document.getElementById('expense_mode').value = mode;

            const normalBtn = document.getElementById('normalExpenseBtn');
            const restockBtn = document.getElementById('restockExpenseBtn');
            const restockFields = document.getElementById('restockFields');
            const amountInput = document.getElementById('amount');
            const amountHelp = document.getElementById('amountHelp');
            const categorySection = document.getElementById('categorySection');

            if (mode === 'restock') {
                restockFields.classList.remove('hidden');
                categorySection.classList.add('hidden');

                amountInput.readOnly = true;
                amountInput.classList.add('bg-slate-100');
                amountHelp.classList.remove('hidden');
                amountHelp.textContent = 'For restock expenses, amount is calculated automatically from quantity added × unit cost.';

                selectCategory('Stock Purchase / Restock');

                restockBtn.classList.add('bg-blue-600', 'text-white');
                restockBtn.classList.remove('bg-white', 'text-slate-700');

                normalBtn.classList.remove('bg-blue-600', 'text-white');
                normalBtn.classList.add('bg-white', 'text-slate-700');
            } else {
                restockFields.classList.add('hidden');
                categorySection.classList.remove('hidden');

                amountInput.readOnly = false;
                amountInput.classList.remove('bg-slate-100');
                amountHelp.classList.add('hidden');
                amountHelp.textContent = 'Amount is calculated automatically.';

                document.getElementById('restock_product_id').value = '';
                document.getElementById('restock_quantity').value = '';
                document.getElementById('unit_cost').value = '';
                amountInput.value = '';

                document.getElementById('category_search').value = '';
                document.getElementById('category').value = '';

                normalBtn.classList.add('bg-blue-600', 'text-white');
                normalBtn.classList.remove('bg-white', 'text-slate-700');

                restockBtn.classList.remove('bg-blue-600', 'text-white');
                restockBtn.classList.add('bg-white', 'text-slate-700');
            }
        }

        function setType(type) {
            currentType = type;
            document.getElementById('type').value = type;

            document.getElementById('category_search').value = '';
            document.getElementById('category').value = '';
            document.getElementById('categoryDropdown').classList.add('hidden');
            showOtherInput(false);

            const saleFields = document.getElementById('saleFields');
            const restockFields = document.getElementById('restockFields');
            const expenseTypeSection = document.getElementById('expenseTypeSection');
            const categorySection = document.getElementById('categorySection');

            const amountInput = document.getElementById('amount');
            const amountHelp = document.getElementById('amountHelp');

            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const stockWarning = document.getElementById('stockWarning');

            saleFields.classList.add('hidden');
            restockFields.classList.add('hidden');
            expenseTypeSection.classList.add('hidden');
            categorySection.classList.remove('hidden');

            amountInput.readOnly = false;
            amountInput.classList.remove('bg-slate-100');
            amountHelp.classList.add('hidden');
            amountHelp.textContent = 'Amount is calculated automatically.';

            productSelect.value = '';
            quantityInput.value = '';
            stockWarning.classList.add('hidden');
            stockWarning.textContent = '';

            document.getElementById('restock_product_id').value = '';
            document.getElementById('restock_quantity').value = '';
            document.getElementById('unit_cost').value = '';
            amountInput.value = '';

            if (type === 'sale') {
                saleFields.classList.remove('hidden');

                amountInput.readOnly = true;
                amountInput.classList.add('bg-slate-100');
                amountHelp.classList.remove('hidden');
                amountHelp.textContent = 'For sales, amount is calculated automatically from product price × quantity.';

                selectCategory('Product Sale');
            }

            if (type === 'expense') {
                expenseTypeSection.classList.remove('hidden');
                setExpenseMode('normal');
            }

            if (type === 'income') {
                document.getElementById('expense_mode').value = 'normal';
            }

            ['income', 'expense', 'sale'].forEach(t => {
                let tab = document.getElementById('tab-' + t);

                if (t === type) {
                    tab.classList.add('bg-blue-600', 'text-white');
                    tab.classList.remove('text-slate-600');
                } else {
                    tab.classList.remove('bg-blue-600', 'text-white');
                    tab.classList.add('text-slate-600');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('category_search');
            const dropdown = document.getElementById('categoryDropdown');

            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');

            const restockQuantityInput = document.getElementById('restock_quantity');
            const unitCostInput = document.getElementById('unit_cost');

            searchInput.addEventListener('focus', function () {
                renderDropdown(this.value);
            });

            searchInput.addEventListener('input', function () {
                document.getElementById('category').value = '';
                renderDropdown(this.value);
            });

            productSelect.addEventListener('change', calculateSaleAmount);
            quantityInput.addEventListener('input', calculateSaleAmount);

            restockQuantityInput.addEventListener('input', calculateRestockAmount);
            unitCostInput.addEventListener('input', calculateRestockAmount);

            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            setType('income');
        });
    </script>
</x-app-layout>