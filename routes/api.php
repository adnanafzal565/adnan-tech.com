<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::post('/seed_products', [ProductController::class, 'seed']);
Route::post("/send_contact_us_message", [UserController::class, "send_contact_us_message"]);
