<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    // GET /products
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json($products, Response::HTTP_OK);
    }

    // POST /products
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
            'criteria' => 'nullable|string',
            'favorite' => 'nullable|boolean',
            'status' => 'nullable|string',
            'stock' => 'required|integer',
        ]);

        $product = Product::create($validatedData);

        return response()->json($product, Response::HTTP_CREATED);
    }

    // GET /products/{id}
    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($product, Response::HTTP_OK);
    }

    // PUT/PATCH /products/{id}
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
            'criteria' => 'nullable|string',
            'favorite' => 'nullable|boolean',
            'status' => 'nullable|string',
            'stock' => 'required|integer',
        ]);

        $product->update($validatedData);

        return response()->json($product, Response::HTTP_OK);
    }

    // DELETE /products/{id}
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], Response::HTTP_OK);
    }
}
