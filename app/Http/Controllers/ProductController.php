<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class productController extends Controller
{
    // GET: Ambil semua data product
    public function index()
    {
        try {
            $products = product::all();
            return response()->json($products, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving products', 'error' => $e->getMessage()], 500);
        }
    }

    // POST: Simpan data product baru
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
    
    // GET: Ambil satu data product berdasarkan ID
    public function show($id)
    {
        try {
            $product = product::find($id);
            if (!$product) {
                return response()->json(['message' => 'product not found'], 404);
            }
            return response()->json($product, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving product', 'error' => $e->getMessage()], 500);
        }
    }

    // PUT/PATCH: Update data product berdasarkan ID
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

    // DELETE: Hapus data product berdasarkan ID
    public function destroy($id)
    {
        try {
            $product = product::find($id);
            if (!$product) {
                return response()->json(['message' => 'product not found'], 404);
            }

            $product->delete();
            return response()->json(['message' => 'product deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting product', 'error' => $e->getMessage()], 500);
        }
    }
}
