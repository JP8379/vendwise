<x-app-layout>
    <div class="min-h-screen bg-slate-100">
        <div class="mx-auto max-w-3xl px-6 py-10">

            {{-- Title --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-800">Add Product</h1>
                <p class="text-slate-600 mt-2">Add a new product to your inventory</p>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-2xl shadow border">

                {{-- Header --}}
                <div class="border-b">
                    <div class="py-3 text-center font-semibold bg-blue-500 text-white rounded-t-2xl">
                        Product Details
                    </div>
                </div>

                {{-- Form --}}
                <div class="p-6">

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('inventory.store') }}">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">

                            {{-- Product Name --}}
                            <div>
                                <label class="text-sm font-medium">Product Name</label>
                                <input type="text" name="name"
                                    placeholder="Enter product name"
                                    class="w-full mt-1 border rounded-lg p-2">
                            </div>

                            {{-- Category --}}
                            <div>
                                <label class="text-sm font-medium">Category</label>
                                <select name="category"
                                    class="w-full mt-1 border rounded-lg p-2">
                                    <option value="">Select category</option>
                                    <option>Package</option>
                                    <option>Service</option>
                                    <option>Product</option>
                                    <option>Other</option>
                                </select>
                            </div>

                            {{-- Stock --}}
                            <div>
                                <label class="text-sm font-medium">Stock Quantity</label>
                                <input type="number" name="stock_quantity"
                                    placeholder="0"
                                    class="w-full mt-1 border rounded-lg p-2">
                            </div>

                            {{-- Price --}}
                            <div>
                                <label class="text-sm font-medium">Price (RM)</label>
                                <input type="number" step="0.01" name="price"
                                    placeholder="0.00"
                                    class="w-full mt-1 border rounded-lg p-2">
                            </div>

                        </div>

                        {{-- Description --}}
                        <div class="mt-4">
                            <label class="text-sm font-medium">Description</label>
                            <textarea name="description"
                                placeholder="Enter product description"
                                class="w-full mt-1 border rounded-lg p-2 h-24"></textarea>
                        </div>

                        {{-- Note --}}
                        <div class="mt-4 bg-slate-100 text-slate-600 text-sm p-3 rounded">
                            <strong>Note:</strong> Product status will be set automatically in Inventory.
                            Items with low stock can be highlighted based on quantity.
                        </div>

                        {{-- BUTTON (IMPORTANT PART) --}}
                        <button type="submit"
                            class="w-full mt-6 bg-blue-500 text-white py-3 rounded-lg font-semibold hover:bg-blue-600">
                            Save Product
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>