<x-app-layout>
    <div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100">
        <x-sidebar />
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

        <main class="flex-1 min-w-0">

            {{-- Mobile header --}}
            <header class="bg-white border-b border-gray-200 px-4 sm:px-8 py-4 flex items-center gap-4">
                <button class="lg:hidden flex flex-col justify-center items-center w-9 h-9 gap-1.5 rounded-lg hover:bg-gray-100 transition shrink-0" onclick="openSidebar()">
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                </button>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Add Product</h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Enter product details to manage your inventory</p>
                </div>
            </header>

            <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-xl border border-red-200 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $defaultCategories = collect(['Package', 'Service']);
                    $savedCategories   = isset($categories) ? collect($categories) : collect();
                    $allCategories     = $defaultCategories->merge($savedCategories)
                        ->filter()->map(fn($c) => trim($c))
                        ->reject(fn($c) => in_array(strtolower($c), ['product','other']))
                        ->unique()->values();
                    $selectedCategory  = old('category');
                @endphp

                <form method="POST" action="{{ route('inventory.store') }}" id="inventoryForm">
                    @csrf

                    {{-- ══ PRODUCT DETAILS CARD ══ --}}
                    <div class="bg-white/95 backdrop-blur rounded-2xl shadow-sm border border-white/70 p-5 sm:p-6 mb-4 sm:mb-5">
                        <h2 class="text-base sm:text-lg font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100">
                            📦 Product Details
                        </h2>

                        {{-- Product Name --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                   placeholder="Example: Cooking Oil" required>
                        </div>

                        {{-- Category --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                            <select name="category" id="categorySelect"
                                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                <option value="">Select category</option>
                                @foreach ($allCategories as $category)
                                    <option value="{{ $category }}" @selected($selectedCategory === $category)>{{ $category }}</option>
                                @endforeach
                                <option value="Other" @selected($selectedCategory === 'Other')>Other</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">If you choose Other, your new category will be saved for next time.</p>
                        </div>

                        {{-- Custom Category --}}
                        <div class="mb-4 hidden" id="customCategoryWrapper">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Custom Category</label>
                            <input type="text" name="custom_category" id="customCategoryInput" value="{{ old('custom_category') }}"
                                   class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                   placeholder="Example: Grocery">
                        </div>

                        {{-- Product Date --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Date <span class="text-red-500">*</span></label>
                            <input type="date" name="product_date"
                                   value="{{ old('product_date', now()->format('Y-m-d')) }}"
                                   max="{{ now()->format('Y-m-d') }}"
                                   class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                            <p class="text-xs text-gray-500 mt-1">The actual date this product stock was recorded.</p>
                        </div>

                        {{-- Stock + Low Stock in a grid --}}
                        <div class="grid grid-cols-2 gap-3 sm:gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock Quantity <span class="text-red-500">*</span></label>
                                <input type="number" name="stock_quantity" id="stockQuantityInput"
                                       value="{{ old('stock_quantity') }}" min="0"
                                       class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                       placeholder="20" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Low Stock Alert Limit <span class="text-red-500">*</span></label>
                                <input type="number" name="low_stock_threshold"
                                       value="{{ old('low_stock_threshold', 5) }}" min="1"
                                       class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                       required>
                                <p class="text-xs text-gray-500 mt-1">Alert when stock reaches this.</p>
                            </div>
                        </div>

                        {{-- Selling Price --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Selling Price per Unit (RM) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="price" id="sellingPriceInput"
                                   value="{{ old('price') }}" min="0"
                                   class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                   placeholder="8.00" required>
                            <p class="text-xs text-gray-500 mt-1">The price you sell this product to customers.</p>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                            <textarea name="description"
                                      class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                      rows="3" placeholder="Optional product description">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    {{-- ══ PURCHASE EXPENSE CARD — shown when stock_quantity > 0 ══ --}}
                    <div id="purchaseExpenseCard"
                         class="bg-orange-50 border border-orange-200 rounded-2xl shadow-sm p-5 sm:p-6 mb-4 sm:mb-5 hidden">

                        <h2 class="text-base sm:text-lg font-bold text-orange-800 mb-1 flex items-center gap-2">
                            💸 Initial Stock Purchase Expense
                        </h2>
                        <p class="text-xs sm:text-sm text-orange-700 mb-4 leading-relaxed">
                            Since you are adding <strong id="stockQtyLabel">0</strong> unit(s) of stock, this purchase will be
                            automatically recorded as an <strong>expense transaction</strong> in your financials.
                        </p>

                        {{-- Hidden field to signal validation --}}
                        <input type="hidden" name="stock_quantity_gt_zero" id="stockGtZero" value="0">

                        {{-- Purchase Cost per Unit --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-orange-800 mb-1.5">
                                Purchase Cost per Unit (RM) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="purchase_cost" id="purchaseCostInput"
                                   value="{{ old('purchase_cost') }}" min="0"
                                   class="w-full rounded-xl border-orange-300 focus:border-orange-500 focus:ring-orange-400 text-sm"
                                   placeholder="5.00">
                            <p class="text-xs text-orange-600 mt-1">How much you paid per unit when buying this stock.</p>
                        </div>

                        {{-- Total cost preview --}}
                        <div class="mb-4 rounded-xl bg-orange-100 border border-orange-200 px-4 py-3 flex items-center justify-between">
                            <span class="text-sm font-medium text-orange-800">Total Expense Amount</span>
                            <span class="text-base sm:text-lg font-bold text-orange-700" id="totalExpenseLabel">RM 0.00</span>
                        </div>

                        {{-- Payment Method --}}
                        <div>
                            <label class="block text-sm font-medium text-orange-800 mb-1.5">
                                Payment Method <span class="text-red-500">*</span>
                            </label>
                            <select name="payment_method"
                                    class="w-full rounded-xl border-orange-300 focus:border-orange-500 focus:ring-orange-400 text-sm">
                                <option value="">Select payment method</option>
                                @foreach(['Cash','Card','Online Transfer','E-Wallet','Bank Transfer','Other'] as $pm)
                                    <option value="{{ $pm }}" @selected(old('payment_method') === $pm)>{{ $pm }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- ══ INFO CARD — shown when stock = 0 ══ --}}
                    <div id="zeroStockInfo"
                         class="bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 mb-4 sm:mb-5 hidden">
                        <p class="text-sm text-slate-600 flex items-start gap-2">
                            <span class="text-lg shrink-0">ℹ️</span>
                            <span>Stock quantity is 0 — no expense will be recorded now. Use <strong>Add Transaction → Expense (Restock)</strong> when you purchase stock later.</span>
                        </p>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3">
                        <a href="{{ route('inventory.index') }}"
                           class="text-center px-6 py-2.5 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 transition text-sm font-medium">
                            Back
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition text-sm font-semibold shadow-lg shadow-blue-200">
                            Save Product
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>

    <script>
        // ── Sidebar ──
        function openSidebar()  { document.getElementById('mobileSidebar').classList.remove('-translate-x-full'); document.getElementById('sidebarOverlay').classList.remove('hidden'); }
        function closeSidebar() { document.getElementById('mobileSidebar').classList.add('-translate-x-full');    document.getElementById('sidebarOverlay').classList.add('hidden'); }

        // ── Category toggle ──
        const categorySelect        = document.getElementById('categorySelect');
        const customCategoryWrapper = document.getElementById('customCategoryWrapper');
        const customCategoryInput   = document.getElementById('customCategoryInput');

        function toggleCustomCategory() {
            const isOther = categorySelect.value === 'Other';
            customCategoryWrapper.classList.toggle('hidden', !isOther);
            isOther ? customCategoryInput.setAttribute('required', 'required') : customCategoryInput.removeAttribute('required');
            if (!isOther) customCategoryInput.value = '';
        }
        toggleCustomCategory();
        categorySelect.addEventListener('change', toggleCustomCategory);

        // ── Purchase expense card toggle ──
        const stockInput          = document.getElementById('stockQuantityInput');
        const purchaseCostInput   = document.getElementById('purchaseCostInput');
        const purchaseExpenseCard = document.getElementById('purchaseExpenseCard');
        const zeroStockInfo       = document.getElementById('zeroStockInfo');
        const stockGtZero         = document.getElementById('stockGtZero');
        const stockQtyLabel       = document.getElementById('stockQtyLabel');
        const totalExpenseLabel   = document.getElementById('totalExpenseLabel');

        function updateExpenseCard() {
            const qty  = parseInt(stockInput.value) || 0;
            const cost = parseFloat(purchaseCostInput.value) || 0;

            if (qty > 0) {
                purchaseExpenseCard.classList.remove('hidden');
                zeroStockInfo.classList.add('hidden');
                stockGtZero.value       = '1';
                stockQtyLabel.textContent = qty;
                purchaseCostInput.setAttribute('required', 'required');
            } else {
                purchaseExpenseCard.classList.add('hidden');
                zeroStockInfo.classList.remove('hidden');
                stockGtZero.value = '0';
                purchaseCostInput.removeAttribute('required');
            }

            const total = qty * cost;
            totalExpenseLabel.textContent = 'RM ' + total.toFixed(2);
        }

        stockInput.addEventListener('input', updateExpenseCard);
        purchaseCostInput.addEventListener('input', updateExpenseCard);

        // Run on page load (handles old() values)
        updateExpenseCard();
    </script>
</x-app-layout>