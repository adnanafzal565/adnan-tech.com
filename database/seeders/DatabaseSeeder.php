<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;
use App\Modules\Category;
use App\Models\User;
use App\Models\Page;
use App\Models\Settings;
use App\Models\App;

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
        $super_admin = User::where("type", "super_admin")->first();

        if (!$super_admin) {
            $super_admin = User::create([
                "name" => env("SUPERADMIN_NAME"),
                "username" => env("SUPERADMIN_USERNAME"),
                "email" => env("SUPERADMIN_EMAIL"),
                "password" => env("SUPERADMIN_PASSWORD"),
                "email_verified_at" => now()->utc(),
                "type" => "super_admin"
            ]);
        }

        $super_admin_id = $super_admin->id;

        $this->seed_apps();

        $title = Settings::where('key', 'title')->value('value') ?? '';
        if (empty($title)) {
            set_setting('title', 'Laravel Boilerplate');
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
            $now = now()->utc();

            Page::insert([
                [
                    "user_id" => $super_admin_id,
                    "title" => "Home",
                    "slug" => "/",
                    "content" => "",
                    "is_active" => 1,
                    "created_at" => $now,
                    "updated_at" => $now,
                ],
                [
                    "user_id" => $super_admin_id,
                    "title" => "About",
                    "slug" => "about",
                    "content" => "<section class=\"about-us\"><h1>About Us</h1><p>Welcome! I'm a passionate web developer with over <strong>8 years of experience</strong> building modern, fast, and reliable web applications. Throughout my career, I've worked on projects of all sizes, helping businesses and individuals turn their ideas into functional, scalable solutions.</p><p>In addition to developing this platform, I also work as a <strong>freelance web developer</strong>. Whether you need a business website, custom web application, API integration, bug fixes, performance optimization, or ongoing maintenance, I'd be happy to help.</p><p>If you're using this project and need features tailored to your specific requirements, I also offer <strong>custom development and customization services</strong>. From small enhancements to completely new modules, I can customize the project to match your workflow and business needs.</p><p>Thank you for visiting, and I look forward to working with you!</p></section>",
                    "is_active" => 1,
                    "created_at" => $now,
                    "updated_at" => $now,
                ],
                [
                    "user_id" => $super_admin_id,
                    "title" => "Contact us",
                    "slug" => "contact",
                    "content" => "",
                    "is_active" => 1,
                    "created_at" => $now,
                    "updated_at" => $now,
                ]
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

    private function seed_apps() {
        $apps = [
            [
                "name" => "Email Renderer",
                "identifier" => "email_renderer"
            ],
            [
                "name" => "Job Runner",
                "identifier" => "job_runner"
            ]
        ];

        foreach ($apps as $app) {
            $exists = App::where("identifier", $app["identifier"])->exists();

            if (!$exists) {
                App::create([
                    "name" => $app["name"],
                    "identifier" => $app["identifier"]
                ]);
            }
        }

        cache()->forget("apps");
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
