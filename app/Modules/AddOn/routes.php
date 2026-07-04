<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\SuperAdmin;
use App\Modules\AddOn\Controllers\AddOnController;

Route::group([
    "prefix" => "/api/addons"
], function () {

    Route::get("/", [AddOnController::class, "index"]);
    Route::get("/{id}", [AddOnController::class, "show"]);

    Route::group([
        "middleware" => [SuperAdmin::class]
    ], function () {
        Route::post("/", [AddOnController::class, "store"]);
        // Route::put("/{id}", [AddOnController::class, "update"]);
        Route::patch("/{id}", [AddOnController::class, "update"]);
        Route::delete("/{id}", [AddOnController::class, "destroy"]);
    });
});