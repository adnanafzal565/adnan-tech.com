<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Str;
use Cache;
use Carbon\Carbon;

class CacheController extends Controller
{
    /**
     * Show all cache entries currently stored in the database cache table.
     */
    public function index(Request $request)
    {
        $connection = config('cache.stores.database.connection') ?: config('database.default');
        $table      = config('cache.stores.database.table', 'cache');
        $prefix     = config('cache.prefix');
 
        $query = DB::connection($connection)->table($table);
 
        if ($search = $request->query('search')) {
            $query->where('key', 'like', '%' . $search . '%');
        }
 
        $rows = $query->orderBy('key')->get();
 
        $caches = $rows->map(function ($row) use ($prefix) {
            $key = ($prefix && Str::startsWith($row->key, $prefix))
                ? Str::after($row->key, $prefix)
                : $row->key;
 
            return (object) [
                'raw_key'    => $row->key,
                'key'        => $key,
                'size_bytes' => strlen((string) ($row->value ?? '')),
                'expires_at' => Carbon::createFromTimestamp($row->expiration),
            ];
        });
 
        $totalSize = $caches->sum('size_bytes');
 
        return view('admin.caches.index', [
            'caches'    => $caches,
            'search'    => $search ?? null,
            'totalSize' => $totalSize,
        ]);
    }
 
    /**
     * Forget a single cache key.
     */
    public function forget(Request $request)
    {
        $request->validate([
            'key' => ['required', 'string'],
        ]);
 
        Cache::forget($request->input('key'));
 
        return back()->with('success', 'Cache "' . $request->input('key') . '" has been cleared.');
    }
 
    /**
     * Flush every entry in the cache store.
     */
    public function clear()
    {
        Cache::flush();
 
        return back()->with('success', 'All caches have been cleared.');
    }
}
