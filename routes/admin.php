<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\Admin;
use App\Http\Middleware\CheckRoutePermission;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\NewsletterController;

Route::group([
    "middleware" => [Admin::class, CheckRoutePermission::class]
], function () {

    Route::get("/subscribers", [NewsletterController::class, "index"])
        ->name("admin.subscribers.index");

    Route::get("/caches", [CacheController::class, "index"])
        ->name("admin.caches.index");

    Route::post("/caches/forget", [CacheController::class, "forget"])
        ->name("admin.caches.forget");

    Route::post("/caches/clear", [CacheController::class, "clear"])
        ->name("admin.caches.clear");

    Route::any("/notifications/create", [NotificationController::class, "create"])
        ->name("admin.notifications.create");

    Route::post("/notifications/mark_as_unread", [NotificationController::class, "mark_as_unread"]);

    Route::get("/notifications", [NotificationController::class, "admin_index"])
        ->name("admin.notifications.index");

    Route::post("/api_keys/update", [ApiKeyController::class, "update"])
        ->name("admin.api_keys.update");

    Route::get("/api_keys/{id}/edit", [ApiKeyController::class, "edit"])
        ->name("admin.api_keys.edit");

    Route::get("/api_keys", [ApiKeyController::class, "admin_index"])
        ->name("admin.api_keys.index");

    Route::get("/apps/{id}", [AppController::class, "admin_detail"])
        ->name("admin.apps.detail");

    Route::get("/apps", [AppController::class, "admin_index"])
        ->name("admin.apps.index");

    Route::post("/products/delete_permanently", [ProductController::class, "delete_permanently"])
        ->name("admin.products.force_delete");

    Route::post("/products/restore", [ProductController::class, "restore"])
        ->name("admin.products.restore");

    Route::get("/products/trash", [ProductController::class, "trash"])
        ->name("admin.products.trash");

    Route::post("/products/destroy", [ProductController::class, "destroy"])
        ->name("admin.products.destroy");

    Route::post("/products/update", [ProductController::class, "update"])
        ->name("admin.products.update");

    Route::get("/products/{id}/edit", [ProductController::class, "edit"])
        ->name("admin.products.edit");

    Route::post("/products/store", [ProductController::class, "store"])
        ->name('admin.products.store');

    Route::get("/products/create", [ProductController::class, "create"])
        ->name("admin.products.create");

    Route::get("/products", [ProductController::class, "admin_index"])
        ->name("admin.products.index");

    Route::post("/contact_us/delete", [AdminController::class, "delete_contact_us"])
        ->name("admin.contact.destroy");

    Route::get("/contact_us", [AdminController::class, "contact_us"])
        ->name("admin.contact.index");

    Route::post("/menus/items/delete", [MenuController::class, "delete_item"])
        ->name("admin.menus.items.destroy");

    Route::post("/menus/items/update", [MenuController::class, "update_item"])
        ->name("admin.menus.items.update");

    Route::post("/menus/items/reorder", [MenuController::class, "reorder_items"])
        ->name("admin.menus.items.reorder");

    Route::post("/menus/items/fetch", [MenuController::class, "fetch_items"])
        ->name("admin.menus.items.fetch");

    Route::post("/menus/items/add", [MenuController::class, "add_item"])
        ->name("admin.menus.items.create");

    Route::post("/menus/add", [MenuController::class, "add"])
        ->name("admin.menus.create");

    Route::get("/menus", [MenuController::class, "index"])
        ->name("admin.menus.index");

    Route::post("/themes/update", [ThemeController::class, "update"])
        ->name("admin.themes.update");

    Route::get("/themes", [ThemeController::class, "index"])
        ->name("admin.themes.index");

    Route::post("/files/delete", [FileController::class, "destroy"])
        ->name("admin.files.destroy");

    Route::post("/files/bulk_upload", [FileController::class, "bulk_upload"])
        ->name("admin.files.bulk_upload");

    Route::post("/files/upload", [FileController::class, "upload"])
        ->name("admin.files.upload");

    Route::any("/files", [FileController::class, "index"])
        ->name("admin.files.index");

    Route::any("/tags/add", [TagController::class, "add"])
        ->name("admin.tags.create");

    Route::any("/categories/add", [CategoryController::class, "add"])
        ->name("admin.categories.create");

    Route::post("/pages/delete", [PageController::class, "destroy"])
        ->name("admin.pages.destroy");

    Route::post("/pages/update", [PageController::class, "update"])
        ->name("admin.pages.update");

    Route::get("/pages/{id}/edit", [PageController::class, "edit"])
        ->name("admin.pages.edit");

    Route::any("/pages/add", [PageController::class, "add"])
        ->name("admin.pages.create");

    Route::get("/pages", [PageController::class, "admin_index"])
        ->name("admin.pages.index");

    Route::post("/posts/delete_permanently", [PostController::class, "delete_permanently"])
        ->name("admin.posts.force_delete");

    Route::post("/posts/restore", [PostController::class, "restore"])
        ->name("admin.posts.restore");

    Route::get("/posts/trash", [PostController::class, "trash"])
        ->name("admin.posts.trash");

    Route::post("/posts/delete", [PostController::class, "destroy"])
        ->name("admin.posts.destroy");

    Route::post("/posts/update", [PostController::class, "update"])
        ->name("admin.posts.update");

    Route::get("/posts/{id}/edit", [PostController::class, "edit"])
        ->name("admin.posts.edit");

    Route::any("/posts/add", [PostController::class, "add"])
        ->name("admin.posts.create");

    Route::get("/posts", [PostController::class, "admin_index"])
        ->name("admin.posts.index");

    Route::post("/send_message", [MessageController::class, "send_admin"])
        ->name("admin.messages.send");

    Route::post("/fetch_messages", [MessageController::class, "fetch_admin"])
        ->name("admin.messages.fetch");

    Route::post("/fetch_contacts", [MessageController::class, "fetch_contacts"])
        ->name("admin.messages.contacts");

    Route::get("/messages", [MessageController::class, "index"])
        ->name("admin.messages.index");

    Route::post("/users/login_as", [UserController::class, "login_as"])
        ->name("admin.users.login_as");

    Route::post("/users/delete_permanently", [UserController::class, "delete_permanently"])
        ->name("admin.users.force_delete");

    Route::post("/users/restore", [UserController::class, "restore"])
        ->name("admin.users.restore");

    Route::get("/users/trash", [UserController::class, "trash"])
        ->name("admin.users.trash");

    Route::post("/users/un_block", [UserController::class, "un_block"])
        ->name("admin.users.unblock");

    Route::post("/users/block", [UserController::class, "block"])
        ->name("admin.users.block");

    Route::post("/users/change_password", [UserController::class, "change_user_password"])
        ->name("admin.users.change_password");

    Route::post("/users/delete", [UserController::class, "destroy"])
        ->name("admin.users.destroy");

    Route::post("/users/update", [UserController::class, "update"])
        ->name("admin.users.update");

    Route::any("/users/add", [UserController::class, "add"])
        ->name("admin.users.create");

    Route::get("/users/edit/{id}", [UserController::class, "edit"])
        ->name("admin.users.edit");

    Route::get("/users/search", [UserController::class, "search"])
        ->name("admin.users.search");

    Route::get("/users", [UserController::class, "index"])
        ->name("admin.users.index");

    Route::post("/save_settings", [SettingsController::class, "save"])
        ->name("admin.settings.update");

    Route::get("/settings", [SettingsController::class, "index"])
        ->name("admin.settings.index");

    Route::get("/", [AdminController::class, "index"])
        ->name("admin.dashboard");
});

Route::any("/login", [AdminController::class, "login"])
    ->name("admin.login");