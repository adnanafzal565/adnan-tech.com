<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use DB;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!Schema::hasTable('contact_us'))
        {
            return;
        }

        View::composer("admin/layouts/app", function ($view) {

            $unread_notifications = 0;

            if (auth()->check()) {
                $unread_notifications = auth()->user()
                    ->notifications()
                    ->where("is_read", 0)
                    ->count();
            }

            $unread_contact_us = DB::table("contact_us")
                ->where("is_read", "=", 0)
                ->count();

            $view->with("unread_contact_us", $unread_contact_us);
            $view->with("unread_notifications", $unread_notifications);
        });
    }
}
