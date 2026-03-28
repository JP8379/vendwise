<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('inventory.index', compact('products'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Product::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'stock_quantity' => $request->stock_quantity,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        return redirect()->route('inventory.index')
            ->with('success', 'Product added successfully.');
    }
}