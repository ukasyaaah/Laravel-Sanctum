<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;
use Exception;

class CategoryController extends Controller
{
    public function index()
    {   
        try {
            $categories = Category::all();
            return ResponseHelper::sendResponse('success', 'Data categories', $categories);
        } catch (Exception $e) {
            return ResponseHelper::sendResponse('error', 'Terjadi kesalahan', $e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {   
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories'
            ]);

            if ($validator->fails()) {
                return ResponseHelper::sendResponse('error', 'Validasi gagal', $validator->errors(), 400);
            }

            $category = Category::create(['name' => $request->name]);
            return ResponseHelper::sendResponse('success', 'Kategori berhasil ditambahkan', $category, 201);
        } catch (Exception $e) {
            return ResponseHelper::sendResponse('error', 'Terjadi kesalahan', $e->getMessage(), 500);
        }
    }

    public function show($id)
    {   
        try {
            $category = Category::find($id);
            if (!$category) {
                return ResponseHelper::sendResponse('error', 'Kategori tidak ditemukan', null, 404);
            }
            return ResponseHelper::sendResponse('success', 'Detail kategori', $category);
        } catch (Exception $e) {
            return ResponseHelper::sendResponse('error', 'Terjadi kesalahan', $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {   
        try {
            $category = Category::find($id);
            if (!$category) {
                return ResponseHelper::sendResponse('error', 'Kategori tidak ditemukan', null, 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $id
            ]);

            if ($validator->fails()) {
                return ResponseHelper::sendResponse('error', 'Validasi gagal', $validator->errors(), 400);
            }

            $category->update(['name' => $request->name]);
            return ResponseHelper::sendResponse('success', 'Kategori berhasil diperbarui', $category);
        } catch (Exception $e) {
            return ResponseHelper::sendResponse('error', 'Terjadi kesalahan', $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {   
        try {
            $category = Category::find($id);
            if (!$category) {
                return ResponseHelper::sendResponse('error', 'Kategori tidak ditemukan', null, 404);
            }

            $category->delete();
            return ResponseHelper::sendResponse('success', 'Kategori berhasil dihapus', null);
        } catch (Exception $e) {
            return ResponseHelper::sendResponse('error', 'Terjadi kesalahan', $e->getMessage(), 500);
        }
    }
}