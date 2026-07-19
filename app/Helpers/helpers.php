<?php

use Illuminate\Support\Facades\Route;

use App\Models\Post;
use App\Models\Page;
use App\Models\Product;
use App\Models\Settings;

function fetch_routes()
{
    $routes = [];

    if (auth()->user()->is_super_admin()) {
        $routes = collect(Route::getRoutes())
            ->filter(function ($route) {

                return str_starts_with($route->getName(), 'admin.');
            })
            ->map(function ($route) {

                return [
                    'name' => $route->getName(),
                    'uri' => $route->uri(),
                    'methods' => implode(',', $route->methods())
                ];

            })
            ->values();
    }

    return $routes;
}

function is_module_exists($name)
{
    return class_exists("App\\Modules\\" . $name . "\\" . $name . "ServiceProvider");
}

function fetch_setting($key)
{
    return cache()->rememberForever($key, function () use ($key) {
        $setting = DB::table("settings")
            ->where("key", "=", $key)
            ->first();

        if ($setting == null)
            return "";

        return $setting->value ?? "";
    });
}

function set_setting($key, $value)
{
    Settings::updateOrCreate(
        [
            "key" => $key
        ],
        [
            "value" => $value
        ]
    );

    cache()->forget($key);
}

function has_post_permission()
{
    if (auth()->check() && in_array(auth()->user()->type, ["super_admin"]))
    {
        return true;
    }

    return false;
}

function forget_page_cache($slug = "")
{
    cache()->forget("page_" . $slug);
}

function get_cached_page($slug = "")
{
    return cache()->rememberForever("page_" . $slug, function () use ($slug) {
        $page = DB::table("pages")
            ->where("slug", "=", $slug)
            ->where("is_active", "=", 1)
            ->first();

        if ($page == null)
        {
            return null;
        }

        return Page::map($page);
    });
}

function forget_post_cache($slug = "")
{
    cache()->forget("post_" . $slug);
}

function get_cached_post($slug = "")
{
    return cache()->rememberForever("post_" . $slug, function () use ($slug) {
        $post = DB::table("posts")
            ->select("posts.*", "users.name AS user_name", "files.file_path")
            ->join("users", "users.id", "=", "posts.user_id")
            ->leftJoin("files", "files.id", "=", "posts.image_id")
            ->where("posts.slug", "=", $slug)
            ->where("posts.is_active", "=", 1);

        if (!has_post_permission())
        {
            $post = $post->whereNull("posts.deleted_at");
        }

        $post = $post->first();

        if ($post == null)
        {
            return null;
        }

        return Post::map($post);
    });
}

function forget_product_cache($slug = "")
{
    cache()->forget("product_" . $slug);
}

function forget_products_cache()
{
    $limit = 15;
    $count = DB::table("products")->count();
    $pages = ceil($count / $limit);

    for ($a = 1; $a <= $pages; $a++)
    {
        cache()->forget("products_" . $a);
    }
}

function get_cached_product($slug = "")
{
    // TODO: uncomment
    // return cache()->rememberForever("product_" . $slug, function () use ($slug) {
        $product = Product::with(['sections'])
            ->where("slug", $slug)
            ->where("is_active", "=", 1)
            ->first();

        return $product;
    // });
}

function get_cached_products($limit = 15)
{
    $page = (int) (request()->page ?? 1);
    return cache()->rememberForever("products_" . $page, function () use ($limit) {
        $posts = Product::where("is_active", "=", 1)
            ->orderBy("id", "desc")
            ->paginate($limit);

        return $posts;
    });
}

function forget_posts_cache()
{
    $limit = 15;
    $count = DB::table("posts")->count();
    $pages = ceil($count / $limit);

    for ($a = 1; $a <= $pages; $a++)
    {
        cache()->forget("posts_" . $a);
    }
}

function get_cached_posts($limit = 15)
{
    $page = (int) (request()->page ?? 1);
    return cache()->rememberForever("posts_" . $page, function () {
        $posts = DB::table("posts")
            ->select("posts.*", "files.file_path")
            ->leftJoin("files", "files.id", "=", "posts.image_id")
            ->where("posts.is_active", "=", 1)
            ->whereNull("posts.deleted_at")
            ->orderBy("posts.is_featured", "desc")
            ->orderBy("posts.id", "desc")
            ->paginate();

        foreach ($posts as $key => $value)
        {
            $posts[$key] = Post::map($value);
        }

        return $posts;
    });
}

function str_replace_all($str, $find, $replace)
{
    return implode($replace, explode($find, $str));
}

function menu_items($name)
{
    return cache()->rememberForever('menu_' . $name, function () use ($name) {
        $menu = DB::table("menus")
            ->where("name", "=", $name)
            ->first();

        if ($menu != null)
        {
            $items = DB::table('menu_items')
                ->where('menu_id', $menu->id)
                ->orderBy('order')
                ->get()
                ->groupBy('parent_id');

            // Root level
            $rootItems = $items[null] ?? [];

            // Nest children manually
            foreach ($rootItems as $key => $item)
            {
                $rootItems[$key]->children = $items[$item->id] ?? [];
            }

            return $rootItems;
        }

        return [];
    });
}

function site_title()
{
    return cache()->rememberForever('title', function () {
        return DB::table('settings')->where('key', 'title')->value('value') ?? '';
    });
}

function active_theme()
{
    if (!Schema::hasTable('settings'))
    {
        return 'default';
    }

    return cache()->rememberForever('active_theme', function () {
        return DB::table('settings')->where('key', 'active_theme')->value('value') ?? 'default';
    });
}

function set_timezone()
{
    $timezone = request()->timezone ?? "";
    if (empty($timezone))
        $timezone = session(config("config.session_timezone_key")) ?? "";
    if (!empty($timezone) && in_array($timezone, timezone_identifiers_list()))
        date_default_timezone_set($timezone);
}