<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;
use App\Modules\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->set_categories();

        $super_admin_id = 0;
        $super_admin = DB::table("users")
            ->where("type", "=", "super_admin")
            ->first();

        if ($super_admin == null)
        {
            $super_admin_id = DB::table("users")
                ->insertGetId([
                    "name" => env("SUPERADMIN_NAME"),
                    "username" => env("SUPERADMIN_USERNAME"),
                    "email" => env("SUPERADMIN_EMAIL"),
                    "password" => password_hash(env("SUPERADMIN_PASSWORD"), PASSWORD_DEFAULT),
                    "email_verified_at" => now()->utc(),
                    "type" => "super_admin",
                    "created_at" => now()->utc(),
                    "updated_at" => now()->utc()
                ]);
        }
        else
        {
            $super_admin_id = $super_admin->id;
        }

        $menus = DB::table("menus")->count();
        if ($menus <= 0)
        {
            $id = DB::table("menus")
                ->insertGetId([
                    "name" => "Main menu",
                    "created_at" => now()->utc(),
                    "updated_at" => now()->utc()
                ]);

            cache()->forget("menu_Main menu");

            DB::table("menu_items")
                ->insertGetId([
                    "menu_id" => $id,
                    "title" => "Home",
                    "url" => "http://localhost:8000",
                    "order" => 1,
                    "created_at" => now()->utc(),
                    "updated_at" => now()->utc()
                ]);

            DB::table("menu_items")
                ->insertGetId([
                    "menu_id" => $id,
                    "title" => "About",
                    "url" => "http://localhost:8000/about",
                    "order" => 2,
                    "created_at" => now()->utc(),
                    "updated_at" => now()->utc()
                ]);

            DB::table("menu_items")
                ->insertGetId([
                    "menu_id" => $id,
                    "title" => "Contact us",
                    "url" => "http://localhost:8000/contact",
                    "order" => 3,
                    "created_at" => now()->utc(),
                    "updated_at" => now()->utc()
                ]);
        }

        $pages = DB::table("pages")->count();
        if ($pages <= 0)
        {
            DB::table("pages")
                ->insertGetId([
                    "user_id" => $super_admin_id,
                    "title" => "Home",
                    "slug" => "/",
                    "is_active" => 1,
                    "created_at" => now()->utc(),
                    "updated_at" => now()->utc()
                ]);

            DB::table("pages")
                ->insertGetId([
                    "user_id" => $super_admin_id,
                    "title" => "About",
                    "slug" => "about",
                    "is_active" => 1,
                    "created_at" => now()->utc(),
                    "updated_at" => now()->utc()
                ]);

            DB::table("pages")
                ->insertGetId([
                    "user_id" => $super_admin_id,
                    "title" => "Contact us",
                    "slug" => "contact",
                    "is_active" => 1,
                    "created_at" => now()->utc(),
                    "updated_at" => now()->utc()
                ]);

            forget_page_cache("/");
            forget_page_cache("about");
            forget_page_cache("contact");
        }

        $active_theme = DB::table('settings')
            ->where('key', 'active_theme')
            ->exists();

        if (!$active_theme)
        {
            DB::table('settings')
                ->insertGetId([
                    "key" => "active_theme",
                    "value" => "default",
                    "created_at" => now()->utc(),
                    "updated_at" => now()->utc()
                ]);
        }
    }

    private function set_categories()
    {
        $categories = ["Smartphones", "Computers", "Clothing", "Jewelry", "Skincare", "Fragrances", "Exercise"];

        foreach ($categories as $category)
        {
            $category_obj = new Category(null, $category);
            $category_data = $category_obj->fetch_single();

            if ($category_data == null)
                $category_obj->add();
        }
    }
}
