<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\AppController;

use App\Http\Middleware\UserAuth;

Route::middleware("web")
    ->group(base_path("routes/admin.php"));

// Route::get('/', function () {
//     return view('welcome');
// });

/*Route::get('/preview', function () {
    set_timezone();

    // dd(admin_email());

    $meta_data = \App\Modules\JobRunner\Models\JobMetaData::where("id", 7)->first();
    $mailable = new \App\Modules\JobRunner\Mails\JobRequestMail($meta_data);

    // $mailable = new \App\Mail\VerifyEmailMail("Adnan", 12345);
    // $mailable = new \App\Mail\WelcomeEmail("Adnan");
    return $mailable->render();

    // dispatch(new \App\Jobs\SendVerifyEmailJob("Adnan", "adnanafzal565@gmail.com", 12345));
    // dispatch(new \App\Jobs\SendWelcomeEmailJob("Adnan", "adnanafzal565@gmail.com"));
});*/

Route::get("/blogs", [PostController::class, "index"])
    ->name("blog.index");

Route::get("/apps", [AppController::class, "index"])
    ->name("apps.index");

Route::any("/apps/{identifier?}", [AppController::class, "detail"])
    ->name("apps.detail");

Route::any("/apps/detail/{identifier?}", [AppController::class, "detail"]);

Route::get("/api_keys/{id}/history", [ApiKeyController::class, "history"]);

Route::get("/api_keys", [ApiKeyController::class, "index"])
    ->name("api_keys.index");

Route::get("/messages/buffer_attachment/{id}/{token?}", [MessageController::class, "buffer_attachment"])
    ->name("messages.buffer_attachment");

Route::get("/author/{username}", [UserController::class, "view_profile"])
    ->name("author");

Route::post("/set_timezone", [UserController::class, "set_user_timezone"])
    ->name("timezone.update");

Route::get("/profile", [UserController::class, "profile"])
    ->name("profile");

Route::get("/change_password", [UserController::class, "change_password"])
    ->name("change_password");

Route::group([
    "middleware" => [UserAuth::class]
], function () {
    Route::post("/me", [UserController::class, "me"]);

    // for admin logout
    Route::get("/logout", [UserController::class, "logout"])
        ->name("logout");
});

Route::get("/email_verification/{email}", [UserController::class, "email_verification"])
    ->name("verification.email");

Route::get("/reset_password/{email}/{token}", [UserController::class, "reset_password_view"])
    ->name("password.reset");

Route::get("/forgot_password", [UserController::class, "forgot_password"])
    ->name("password.request");

Route::get("/register", [UserController::class, "register"])
    ->name("register");

Route::get("/login", [UserController::class, "login"])
    ->name("login");

Route::get("/", [UserController::class, "home"])
    ->name("home");

Route::get("/{slug}", [PageController::class, "detail"])
    ->where('slug', '^[a-zA-Z0-9-_]+$')
    ->name("pages.show");