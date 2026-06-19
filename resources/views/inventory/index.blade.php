<x-app-layout>
    @php
        $summaryProducts  = $allProducts ?? $products;
        $totalProducts    = $summaryProducts->count();
        $lowStockItems    = $summaryProducts->filter(fn($p) => $p->stock_quantity > 0 && $p->stock_quantity <= $p->low_stock_threshold)->count();
        $outOfStockItems  = $summaryProducts->filter(fn($p) => $p->stock_quantity == 0)->count();
        $totalStockValue  = $summaryProducts->sum(fn($p) => $p->price * $p->stock_quantity);
    @endphp

    <div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100">
        <x-sidebar />
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

        <main class="flex-1 min-w-0">

            <header class="bg-white border-b border-gray-200 px-4 sm:px-8 py-4 flex items-center justify-between gap-4">
                <button class="lg:hidden flex flex-col justify-center items-center w-9 h-9 gap-1.5 rounded-lg hover:bg-gray-100 transition" onclick="openSidebar()">
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                </button>
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-3xl font-bold text-slate-800 truncate">Inventory</h1>
                    <p class="text-xs sm:text-sm text-slate-600 mt-0.5 hidden sm:block">Manage your products and stock levels</p>
                </div>
                <a href="{{ route('inventory.create') }}"
                   class="shrink-0 px-3 sm:px-5 py-2 sm:py-2.5 bg-blue-600 text-white rounded-xl text-xs sm:text-sm font-semibold shadow hover:bg-blue-700 transition">
                    + Add
                </a>
            </header>

            <div class="p-4 sm:p-6 lg:p-8 space-y-5 sm:space-y-6">

                {{-- Summary Cards --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                    <div class="bg-white/90 backdrop-blur p-3 sm:p-5 rounded-2xl shadow-sm border border-white/70">
                        <p class="text-xs sm:text-sm text-gray-500">Total Products</p>
                        <h2 class="text-xl sm:text-2xl font-bold mt-1 sm:mt-2 text-slate-800">{{ $totalProducts }}</h2>
                    </div>
                    <div class="bg-white/90 backdrop-blur p-3 sm:p-5 rounded-2xl shadow-sm border border-white/70">
                        <p class="text-xs sm:text-sm text-gray-500">Low Stock</p>
                        <h2 class="text-xl sm:text-2xl font-bold mt-1 sm:mt-2 text-orange-500">{{ $lowStockItems }}</h2>
                    </div>
                    <div class="bg-white/90 backdrop-blur p-3 sm:p-5 rounded-2xl shadow-sm border border-white/70">
                        <p class="text-xs sm:text-sm text-gray-500">Out of Stock</p>
                        <h2 class="text-xl sm:text-2xl font-bold mt-1 sm:mt-2 text-red-500">{{ $outOfStockItems }}</h2>
                    </div>
                    <div class="bg-white/90 backdrop-blur p-3 sm:p-5 rounded-2xl shadow-sm border border-white/70">
                        <p class="text-xs sm:text-sm text-gray-500">Stock Value</p>
                        <h2 class="text-base sm:text-2xl font-bold mt-1 sm:mt-2 text-green-600">RM{{ number_format($totalStockValue, 2) }}</h2>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded-xl border border-green-200 text-sm">{{ session('success') }}</div>
                @endif

                {{-- Search and Filter --}}
                <div class="bg-white/95 backdrop-blur rounded-2xl shadow-sm border border-white/70 p-4 sm:p-5">
                    <form method="GET" action="{{ route('inventory.index') }}">
                        <div class="flex flex-col gap-3 sm:grid sm:grid-cols-12 sm:gap-4 sm:items-end">
                            <div class="sm:col-span-5">
                                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1.5">Search Product</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search product, category..."
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1.5">Status</label>
                                <select name="status" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="all"          {{ !request('status') || request('status') == 'all'          ? 'selected' : '' }}>All</option>
                                    <option value="in_stock"     {{ request('status') == 'in_stock'     ? 'selected' : '' }}>In Stock</option>
                                    <option value="low_stock"    {{ request('status') == 'low_stock'    ? 'selected' : '' }}>Low Stock</option>
                                    <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                            </div>
                            <div class="sm:col-span-3 flex gap-2">
                                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition text-sm">Filter</button>
                                <a href="{{ route('inventory.index') }}" class="flex-1 text-center px-4 py-2.5 bg-slate-200 text-slate-700 rounded-xl font-medium hover:bg-slate-300 transition text-sm">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Inventory Table --}}
                <div class="bg-white/95 backdrop-blur rounded-2xl shadow-sm border border-white/70 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b border-slate-100">
                        <h2 class="font-semibold text-slate-800">Product List</h2>
                        <p class="text-xs text-slate-500 mt-1">Showing {{ $products->count() }} product(s)</p>
                    </div>

                    @if($products->isEmpty())
                        <div class="py-12 text-center">
                            <p class="text-slate-500 font-medium">No products found.</p>
                            <p class="text-slate-400 text-sm mt-1">Try changing your search or status filter.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left">
                                <thead class="bg-slate-50 border-b border-slate-200">
                                    <tr>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-slate-700 font-semibold text-xs sm:text-sm">Product</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-slate-700 font-semibold text-xs sm:text-sm hidden sm:table-cell">Category</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-slate-700 font-semibold text-xs sm:text-sm hidden lg:table-cell">Product Date</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-slate-700 font-semibold text-xs sm:text-sm">Stock</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-slate-700 font-semibold text-xs sm:text-sm hidden md:table-cell">Low Stock Limit</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-slate-700 font-semibold text-xs sm:text-sm">Price</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-slate-700 font-semibold text-xs sm:text-sm hidden xl:table-cell">Description</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-slate-700 font-semibold text-xs sm:text-sm hidden lg:table-cell">Last Updated</th>
                                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-slate-700 font-semibold text-xs sm:text-sm">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($products as $product)
                                        @php
                                            $isOutOfStock = $product->stock_quantity == 0;
                                            $isLowStock   = $product->stock_quantity > 0 && $product->stock_quantity <= $product->low_stock_threshold;
                                        @endphp
                                        <tr class="hover:bg-blue-50/50 transition">
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 font-semibold text-gray-800 text-xs sm:text-sm">{{ $product->name }}</td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 hidden sm:table-cell">
                                                <span class="px-2 sm:px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-medium">{{ $product->category ?? '-' }}</span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 text-gray-700 whitespace-nowrap text-xs sm:text-sm hidden lg:table-cell">
                                                {{ $product->product_date ? $product->product_date->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 text-xs sm:text-sm">
                                                <span class="{{ ($isLowStock || $isOutOfStock) ? 'text-red-500 font-bold' : 'text-gray-700 font-medium' }}">{{ $product->stock_quantity }}</span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 text-gray-700 text-xs sm:text-sm hidden md:table-cell">{{ $product->low_stock_threshold }}</td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 text-gray-700 whitespace-nowrap text-xs sm:text-sm">RM{{ number_format($product->price, 2) }}</td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 text-gray-600 text-xs sm:text-sm hidden xl:table-cell">{{ \Illuminate\Support\Str::limit($product->description, 40) ?: '-' }}</td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5 text-gray-700 whitespace-nowrap text-xs sm:text-sm hidden lg:table-cell">{{ $product->updated_at ? $product->updated_at->format('d/m/Y') : '-' }}</td>
                                            <td class="px-4 sm:px-6 py-3 sm:py-5">
                                                @if($isOutOfStock)
                                                    <span class="px-2 sm:px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-semibold">Out of Stock</span>
                                                @elseif($isLowStock)
                                                    <span class="px-2 sm:px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-semibold">Low Stock</span>
                                                @else
                                                    <span class="px-2 sm:px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-semibold">In Stock</span>
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