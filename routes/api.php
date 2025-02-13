<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

//! auth
Route::post('/register', [AuthController::class, 'register']); //* ini untuk register
Route::post ('/login', [AuthController::class, 'login']); //*ini untuk login
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); //* ini untuk logout
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUser']); //*ini untuk mengembil data user yg sedang login
Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->apiResource('products', ProductController::class);

