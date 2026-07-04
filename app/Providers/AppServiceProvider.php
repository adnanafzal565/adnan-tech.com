<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $modules_folder = app_path("Modules");

        if (File::exists($modules_folder))
        {
            $modules = File::directories($modules_folder);
            
            foreach ($modules as $module)
            {
                $module_name = basename($module);
                $class_name = "App\Modules\\" . $module_name . "\\" . $module_name . "ServiceProvider";

                if (class_exists($class_name))
                {
                    $this->app->register($class_name);
                }
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::addNamespace('theme', resource_path('views/themes/' . active_theme()));
    }
}
