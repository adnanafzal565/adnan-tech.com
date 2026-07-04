<?php

namespace App\Modules\AddOn;

use Illuminate\Support\ServiceProvider;

class AddOnServiceProvider extends ServiceProvider
{
    public function register()
    {
        // 
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . "/routes.php");
        $this->loadViewsFrom(__DIR__ . "/Views", "AddOn");
        $this->loadMigrationsFrom(__DIR__ . "/migrations");

        $this->publishes([
            __DIR__ . "/assets" => public_path("modules/addon")
        ], "addon-assets");

        $includes = [
            __DIR__ . "/helpers.php"
        ];
        
        foreach ($includes as $include)
        {
            if (file_exists($include))
            {
                require_once $include;
            }
        }
    }
}