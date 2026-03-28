<x-app-layout>
    <div class="min-h-screen bg-slate-100">
        <div class="mx-auto max-w-7xl px-7 py-10">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <h1 class="text-5xl font-extrabold tracking-tight text-slate-900">Inventory</h1>
                    <p class="mt-2 text-xl text-slate-600">Manage your products and stock levels</p>
                </div>

                <a href="{{ route('inventory.create') }}"
                   class="inline-flex items-center rounded-2xl bg-blue-500 px-7 py-4 text-lg font-semibold text-white shadow-sm transition hover:bg-blue-600">
                    + Add Product
                </a>
            </div>

            @php
                $totalProducts = $products->count();
                $lowStockItems = $products->filter(fn($product) => $product->stock_quantity <= 10)->count();
                $totalStockValue = $products->sum(fn($product) => $product->stock_quantity * $product->price);
            @endphp

            {{-- Stats --}}
            <div class="mb-8 grid gap-6 md:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-white px-7 py-6 shadow-sm">
                    <p class="text-base text-slate-500">Total Products</p>
                    <h2 class="mt-3 text-5xl font-bold text-slate-900">{{ $totalProducts }}</h2>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white px-7 py-6 shadow-sm">
                    <p class="text-base text-slate-500">Low Stock Items</p>
                    <h2 class="mt-3 text-5xl font-bold text-red-500">{{ $lowStockItems }}</h2>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white px-7 py-6 shadow-sm">
                    <p class="text-base text-slate-500">Total Stock Value</p>
                    <h2 class="mt-3 text-5xl font-bold text-green-500">RM{{ number_format($totalStockValue, 2) }}</h2>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-green-100 px-5 py-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-slate-50">
                            <tr class="border-b border-slate-200 text-left text-base font-semibold text-slate-600">
                                <th class="px-8 py-5">Product Name</th>
                                <th class="px-8 py-5">Stock Quantity</th>
                                <th class="px-8 py-5">Price</th>
                                <th class="px-8 py-5">Last Updated</th>
                                <th class="px-8 py-5">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            @forelse($products as $product)
                                @php
                                    $isLowStock = $product->stock_quantity <= 10;
                                @endphp

                                <tr class="text-lg text-slate-700">
                                    <td class="px-8 py-6 font-semibold text-slate-900">
                                        {{ $product->name }}
                                    </td>

                                    <td class="px-8 py-6 font-semibold {{ $isLowStock ? 'text-red-500' : 'text-slate-800' }}">
                                        {{ $product->stock_quantity }}
                                    </td>

                                    <td class="px-8 py-6 font-medium">
                                        ${{ number_format($product->price, 2) }}
                                    </td>

                                    <td class="px-8 py-6 text-slate-700">
                                        {{ $product->updated_at ? $product->updated_at->format('Y-m-d') : '-' }}
                                    </td>

                                    <td class="px-8 py-6">
                                        @if($isLowStock)
                                            <span class="inline-flex items-center rounded-full bg-red-50 px-4 py-2 text-sm font-semibold text-red-500">
                                                Low Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                                                In Stock
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-10 text-center text-lg text-slate-500">
                                        No products found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>