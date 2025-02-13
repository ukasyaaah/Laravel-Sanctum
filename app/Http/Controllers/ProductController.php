<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Mendapatkan semua produk (GET)
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    // Menyimpan produk baru (POST)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255'
        ]);

        $product = Product::create($request->all());

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    // Menampilkan produk berdasarkan ID (GET)
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }
}