<?php

use Illuminate\Support\Facades\Route;

use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Models\App;
use App\Models\Post;
use App\Models\Page;
use App\Models\Product;
use App\Models\Settings;
use App\Models\ApiKey;
use App\Models\ApiKeyRequestLog;

/**
 * Decrypt a user's stored webhook secret for attaching to an
 * outgoing request. Returns null if it can't be decrypted (e.g.
 * APP_KEY was rotated since it was encrypted) rather than throwing,
 * so a bad secret never breaks the job run itself.
 */
function decrypt_webhook_secret(string $encrypted): ?string
{
    try {
        return Crypt::decryptString($encrypted);
    } catch (DecryptException $e) {
        return null;
    }
}


/**
 * Hash a plaintext secret for storage/lookup. Only this hash is
 * ever persisted — the plaintext secret is never stored.
 */
function hash_secret(string $plain_secret): string
{
    return hash('sha256', $plain_secret);
}

if (!function_exists('canonical_url')) {
    /**
     * Build a canonical URL for the current request:
     * - Forces the canonical scheme + host (from config('app.url'))
     * - Normalizes trailing slashes
     * - Strips known non-content query params (tracking, session, ad-click IDs)
     * - Keeps any remaining query params (assumed content-relevant, e.g. pagination,
     *   filters) in a consistent, sorted order so equivalent URLs canonicalize the same way
     */
    function canonical_url(): string
    {
        // Params that never affect page content — always stripped.
        $denylist = [
            'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
            'gclid', 'fbclid', 'msclkid', 'mc_cid', 'mc_eid',
            'ref', 'source', 'affiliate',
            'session_id', 'sessionid', 'phpsessid', 'sid',
        ];

        $path = request()->getPathInfo();

        // Normalize trailing slash (keep root "/" as-is).
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        $query = request()->query();

        // Case-insensitive removal of denylisted params.
        $query = array_filter(
            $query,
            fn ($value, $key) => !in_array(strtolower($key), $denylist, true),
            ARRAY_FILTER_USE_BOTH
        );

        // Consistent ordering so ?b=2&a=1 and ?a=1&b=2 canonicalize identically.
        ksort($query);

        $base = rtrim(config('app.url'), '/') . $path;

        return empty($query) ? $base : $base . '?' . http_build_query($query);
    }
}

function map_string($key)
{
    $keys = [
        "facebook" => "Facebook",
        "instagram" => "Instagram",
        "youtube" => "YouTube",
        "github" => "GitHub",
        "linkedin" => "LinkedIn",
        "twitter" => "Twitter",
        "x" => "X",
        "tiktok" => "TikTok",
        "pinterest" => "Pinterest",
        "reddit" => "Reddit",
        "whatsapp" => "WhatsApp",
        "telegram" => "Telegram",
        "discord" => "Discord",
        "twitch" => "Twitch",
        "snapchat" => "Snapchat",
        "threads" => "Threads",
        "medium" => "Medium",
        "stackoverflow" => "Stack Overflow",
        "stackexchange" => "Stack Exchange",
        "behance" => "Behance",
        "dribbble" => "Dribbble",
        "vimeo" => "Vimeo",
        "quora" => "Quora",
        "skype" => "Skype",
        "tumblr" => "Tumblr",
        "flickr" => "Flickr",
        "weibo" => "Weibo",
        "wechat" => "WeChat",
        "vk" => "VK",
        "line" => "LINE",
        "kakao" => "KakaoTalk",
        "patreon" => "Patreon",
        "substack" => "Substack",
        "gitlab" => "GitLab",
        "bitbucket" => "Bitbucket",
        "npm" => "npm",
        "docker" => "Docker",
        "producthunt" => "Product Hunt",
        "google" => "Google",
        "google_maps" => "Google Maps",
        "google_play" => "Google Play",
        "apple" => "Apple",
        "apple_music" => "Apple Music",
        "spotify" => "Spotify",
    ];

    return $keys[$key] ?? ucfirst($key);
}

function price_per_request($plan)
{
    if (!empty($plan['is_custom']) || empty($plan['price']) || empty($plan['requests'])) {
        return '$0';
    }
    $per = $plan['price'] / $plan['requests'];
    return $per < 0.01
        ? '$' . number_format($per, 5)
        : format_currency($per);
}

function format_currency($amount)
{
    if ($amount === null) {
        return '—';
    }

    $currency = env("CURRENCY_CODE");

    $symbol = $currency === 'USD' ? '$' : $currency . ' ';
    $decimals = (floor($amount) == $amount) ? 0 : 4;
    return $symbol . number_format($amount, $decimals);
}

function format_number($count)
{
    return $count === null ? '—' : number_format($count);
}

function get_faqs()
{
    $free_requests = config("config.free_api_requests_per_key");
    
    return [
        [
            'question' => 'Do my API request credits expire?',
            'answer' => "No. Credits are yours once purchased — there's no expiry date and no monthly subscription. Use them at your own pace.",
        ],
        [
            'question' => 'What happens when I run out of requests?',
            'answer' => "API calls beyond your remaining balance are rejected until you buy more credits. We don't auto-upgrade your plan or charge overage fees — you're always in control of what you spend.",
        ],
        [
            'question' => 'What counts as an API request?',
            'answer' => "Each call to any API endpoint deducts one credit from your balance, regardless of response size. Failed requests due to invalid authentication don't count; failed requests due to invalid input do.",
        ],
        [
            'question' => "What's the rate limit, and is it different from my credit balance?",
            'answer' => "Yes — separate things. Your credit balance is the total number of requests you can make before topping up. The rate limit caps how many requests per second you can send, to keep the API stable for everyone. Each plan lists its own rate limit above.",
        ],
        [
            'question' => 'Is there a monthly fee on top of the credits?',
            'answer' => "No. You pay once for a block of credits and that's it — no recurring charges, no subscription to cancel.",
        ],
        [
            'question' => 'Can I get a refund on unused credits?',
            'answer' => "We don't offer refunds once a purchase is made. Because credits never expire, there's no time pressure to use them — you can spread usage out for as long as you like.",
        ],
        [
            'question' => 'I need more than your largest plan offers — what are my options?',
            'answer' => 'Our Custom plan covers high-volume or bespoke needs: negotiated per-request pricing, custom rate limits, and a dedicated account manager. Reach out and we\'ll put together a package that fits.',
        ],
        [
            'question' => 'Do I get any free requests to try the API first?',
            'answer' => "Yes — your first API key includes {$free_requests} free requests, no card required, so you can test the integration before buying credits.",
        ],
    ];
}

function get_comparison_rows()
{
    return [
        ['label' => 'Price', 'value' => fn (array $p) => !empty($p['is_custom']) ? 'Custom' : format_currency($p['price'] ?? null)],
        ['label' => 'API requests included', 'value' => fn (array $p) => !empty($p['is_custom']) ? 'Flexible' : format_number($p['requests'] ?? null)],
        ['label' => 'Price per request', 'value' => fn (array $p) => price_per_request($p) ?? '—'],
        ['label' => 'Rate limit', 'value' => fn (array $p) => $p['rate_limit'] ?? '—'],
        ['label' => 'Support', 'value' => fn (array $p) => $p['support'] ?? '—'],
        ['label' => 'Uptime SLA', 'value' => fn (array $p) => $p['uptime_sla'] ?? '—'],
        ['label' => 'Credit expiry', 'value' => fn (array $p) => 'Never'],
        ['label' => 'Monthly fee', 'value' => fn (array $p) => 'None'],
    ];
}

function get_plans()
{
    return [
        [
            'id' => 'trial', 'name' => 'Trial',
            'description' => 'For trying out the API.',
            'price' => 0, 'requests' => 50,
            'rate_limit' => '100 requests/min',
            // 'requests_per_second' => 10,
            'requests_per_minute' => 100,
            'support' => 'Priority support',
            'uptime_sla' => '99.99%',
            // 'features' => ['REST + GraphQL access', 'Usage dashboard', 'Webhook support'],
            'cta_label' => 'Buy credits', 'cta_url' => '/checkout?plan=trial',
            'popular' => false,
        ],
        [
            'id' => 'starter', 'name' => 'Starter',
            'description' => 'For side projects and testing.',
            'price' => 99, 'requests' => 1000000,
            'rate_limit' => '500 requests/min',
            // 'requests_per_second' => 10,
            'requests_per_minute' => 500,
            'support' => 'Priority support',
            'uptime_sla' => '99.99%',
            // 'features' => ['REST + GraphQL access', 'Usage dashboard', 'Webhook support'],
            'cta_label' => 'Buy credits', 'cta_url' => '/checkout?plan=starter',
            'popular' => false,
        ],
        /*[
            'id' => 'growth', 'name' => 'Growth',
            'description' => 'For growing products with steady traffic.',
            'price' => 249, 'requests' => 3000000,
            'rate_limit' => '1500 requests/min',
            // 'requests_per_second' => 25,
            'requests_per_minute' => 1500,
            'support' => 'Priority support',
            'uptime_sla' => '99.99%',
            // 'features' => ['REST + GraphQL access', 'Usage dashboard', 'Webhook support', 'Priority queue'],
            'cta_label' => 'Buy credits', 'cta_url' => '/checkout?plan=growth',
            'popular' => false,
        ],*/
        [
            'id' => 'professional', 'name' => 'Professional',
            'description' => 'For teams running production workloads.',
            'price' => 499, 'requests' => 7000000,
            'rate_limit' => '3000 requests/min',
            // 'requests_per_second' => 50,
            'requests_per_minute' => 3000,
            'support' => 'Priority support',
            'uptime_sla' => '99.99%',
            // 'features' => ['REST + GraphQL access', 'Usage dashboard', 'Webhook support', 'Priority queue', 'Team seats'],
            'cta_label' => 'Buy credits', 'cta_url' => '/checkout?plan=professional',
            'popular' => true,
        ],
        [
            'id' => 'enterprise', 'name' => 'Enterprise',
            'description' => 'For high-volume, mission-critical usage.',
            'price' => 999, 'requests' => 16000000,
            'rate_limit' => '6000 requests/min',
            // 'requests_per_second' => 100,
            'requests_per_minute' => 6000,
            'support' => 'Priority support',
            'uptime_sla' => '99.99%',
            // 'features' => ['REST + GraphQL access', 'Usage dashboard', 'Webhook support', 'Priority queue', 'Team seats', 'Dedicated account manager'],
            'cta_label' => 'Buy credits', 'cta_url' => '/checkout?plan=enterprise',
            'popular' => false,
        ],
    ];
}

function get_cached_apps()
{
    return cache()->rememberForever("apps", function () {
        return App::orderBy("name", "ASC")->get();
    });
}

function add_api_key_request_log(
    $title = "",
    $content = ""
)
{
    // $api_key_str = request()->api_key;
    $api_key_str = request()->attributes->get("api_key");

    $api_key = ApiKey::where("key", $api_key_str)
        ->first();

    if ($api_key) {
        $ip_address = request()->input("ip");

        if (empty($ip_address)) {
            $ip_address = request()->ip();
        }

        $device = request()->input("device");

        if (empty($device)) {
            $agent = new Agent();

            $device = [
                "device" => $agent->device(),
                "platform" => $agent->platform(),
                "platform_version" => $agent->version($agent->platform()),
                "browser" => $agent->browser(),
                "browser_version" => $agent->version($agent->browser()),
                "is_mobile" => $agent->isMobile(),
                "is_tablet" => $agent->isTablet(),
                "is_desktop" => $agent->isDesktop(),
                "user_agent" => request()->userAgent(),
            ];
        } else {
            $device = json_decode($device, true);
        }

        ApiKeyRequestLog::create([
            "api_key_id" => $api_key->id,
            "title" => $title,
            "content" => $content,
            "device" => $device,
            "ip" => $ip_address,
            "remaining" => $api_key->remaining
        ]);
    }
}

function api_key_header_key()
{
    return "X-API-KEY";
}

function base_url()
{
    return "http://localhost:8000";
    // return "https://adnan-tech.com";
}

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

function fetch_setting($keys)
{
    $is_single = !is_array($keys);

    $keys = $is_single ? [$keys] : $keys;

    $cache_key = "settings_" . md5(json_encode($keys));

    return cache()->rememberForever($cache_key, function () use ($keys, $is_single) {
        $settings = Settings::whereIn("key", $keys)
            ->pluck("value", "key")
            ->toArray();

        $data = [];

        foreach ($keys as $key) {
            $data[$key] = $settings[$key] ?? "";
        }

        return $is_single
            ? ($data[$keys[0]] ?? "")
            : $data;
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

    $cache_key = "settings_" . md5(json_encode([$key]));

    cache()->forget($cache_key);
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

function forget_featured_post_cache()
{
    cache()->forget("featured_post");
}

function get_cached_featured_post()
{
    return cache()->rememberForever("featured_post", function () {
        return Post::where("is_active", 1)
            ->where("is_featured", 1)
            ->first();
    });
}

function get_cached_post($slug = "")
{
    return cache()->rememberForever("post_" . $slug, function () use ($slug) {

        return Post::with(["user"])
            ->where("slug", "=", $slug)
            ->where("is_active", 1)
            ->first();

        /*$post = DB::table("posts")
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

        return Post::map($post);*/
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

function get_cached_products()
{
    // $page = (int) (request()->page ?? 1);
    // return cache()->rememberForever("products_" . $page, function () use ($limit) {
        $posts = Product::where("is_active", "=", 1)
            ->orderBy("id", "desc")
            ->paginate(config("config.PER_PAGE"));

        return $posts;
    // });
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

function get_cached_posts()
{
    $page = (int) (request()->page ?? 1);
    return cache()->rememberForever("posts_" . $page, function () {

        return Post::where("is_active", "=", 1)
            ->orderBy("is_featured", "desc")
            ->orderBy("id", "desc")
            ->paginate(config("config.PER_PAGE"));

        /*$posts = DB::table("posts")
            ->select("posts.*", "files.file_path")
            ->leftJoin("files", "files.id", "=", "posts.image_id")
            ->where("posts.is_active", "=", 1)
            ->whereNull("posts.deleted_at")
            ->orderBy("posts.is_featured", "desc")
            ->orderBy("posts.id", "desc")
            ->paginate(config("config.PER_PAGE"));

        foreach ($posts as $key => $value)
        {
            $posts[$key] = Post::map($value);
        }

        return $posts;*/
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

function admin_email()
{
    return cache()->rememberForever('admin_email', function () {
        return DB::table('settings')->where('key', 'admin_email')->value('value') ?? '';
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

if (!function_exists("set_timezone"))
{
    function set_timezone($timezone = "")
    {
        if (!empty($timezone)) {
            date_default_timezone_set($timezone);
            return;
        }
        
        $timezone = request()->timezone ?? "";
        if (empty($timezone))
            $timezone = session(config("config.session_timezone_key")) ?? "";
        if (!empty($timezone) && in_array($timezone, timezone_identifiers_list()))
            date_default_timezone_set($timezone);
    }
}