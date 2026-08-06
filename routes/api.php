<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ApiKeyController;

use App\Http\Middleware\UserAuth;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::post('/seed_products', [ProductController::class, 'seed']);
Route::post("/send_contact_us_message", [UserController::class, "send_contact_us_message"]);

Route::post("/verify_email", [UserController::class, "verify_email"]);

Route::post("/register", [UserController::class, "register"]);

Route::post("/login", [UserController::class, "login"]);

Route::group([
    "middleware" => ['auth:sanctum', UserAuth::class]
], function () {
    Route::post("/api_keys/history", [ApiKeyController::class, "fetch_history"]);

    Route::post("/api_keys/toggle_status", [ApiKeyController::class, "toggle_status"]);
    
    Route::post("/api_keys/store", [ApiKeyController::class, "store"]);

    Route::post("/api_keys/all", [ApiKeyController::class, "fetch_all"]);

    Route::post("/api_keys", [ApiKeyController::class, "fetch"]);

    Route::post("/messages/mark_as_read", [MessageController::class, "mark_as_read"]);
    
    Route::post("/messages/fetch", [MessageController::class, "fetch"]);

    Route::post("/messages/send", [MessageController::class, "send"]);

    Route::post("/logout", [UserController::class, "logout"]);

    Route::post("/change_password", [UserController::class, "change_password"]);

    Route::post("/profile", [UserController::class, "profile"]);

    Route::post("/me", [UserController::class, "me"]);
});
