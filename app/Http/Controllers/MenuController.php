<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Storage;
use Validator;

class MenuController extends Controller
{
    public function delete_item()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $user = auth()->user();
        $id = request()->id ?? 0;

        $menu_item = DB::table("menu_items")
            ->select("menu_items.*", "menus.name AS menu_name")
            ->join("menus", "menus.id", "=", "menu_items.menu_id")
            ->where("menu_items.id", "=", $id)
            ->first();

        if ($menu_item == null)
        {
            return response()->json([
                "status" => "error",
                "message" => "Menu item not found."
            ]);
        }

        DB::table("menu_items")
            ->where("id", "=", $id)
            ->delete();

        cache()->forget("menu_" . ($menu_item->menu_name ?? ""));

        return response()->json([
            "status" => "success",
            "message" => "Menu item has been deleted."
        ]);
    }

    public function update_item()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required",
            "title" => "required",
            "url" => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $user = auth()->user();
        $id = request()->id ?? 0;
        $title = request()->title ?? "";
        $url = request()->url ?? "";

        $menu_item = DB::table("menu_items")
            ->select("menu_items.*", "menus.name AS menu_name")
            ->join("menus", "menus.id", "=", "menu_items.menu_id")
            ->where("menu_items.id", "=", $id)
            ->first();

        if ($menu_item == null)
        {
            return response()->json([
                "status" => "error",
                "message" => "Menu item not found."
            ]);
        }

        DB::table("menu_items")
            ->where("id", "=", $id)
            ->update([
                "title" => $title,
                "url" => $url,
                "updated_at" => now()->utc()
            ]);

        cache()->forget("menu_" . ($menu_item->menu_name ?? ""));

        return response()->json([
            "status" => "success",
            "message" => "Menu item has been updated."
        ]);
    }

    public function reorder_items()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required",
            "order" => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $user = auth()->user();
        $id = request()->id ?? 0;
        $order = json_decode(request()->order ?? "[]", true);

        $menu = DB::table("menus")
            ->where("id", "=", $id)
            ->first();

        if ($menu == null)
        {
            return response()->json([
                "status" => "error",
                "message" => "Menu not found."
            ]);
        }

        foreach ($order as $index => $itemId)
        {
            DB::table("menu_items")
                ->where("id", "=", $itemId)
                ->update([
                    'order' => $index,
                    "updated_at" => now()->utc()
                ]);
        }

        cache()->forget("menu_" . ($menu->name ?? ""));

        return response()->json([
            "status" => "success",
            "message" => "Menu items has been saved."
        ]);
    }

    public function fetch_items()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $user = auth()->user();
        $id = request()->id ?? 0;

        if (!DB::table("menus")->where("id", "=", $id)->exists())
        {
            return response()->json([
                "status" => "error",
                "message" => "Menu not found."
            ]);
        }

        $items = DB::table('menu_items')
            ->where('menu_id', $id)
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

        return response()->json([
            "status" => "success",
            "message" => "Menu items has been fetched.",
            "items" => $rootItems
        ]);
    }

    public function add_item()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required",
            "title" => "required",
            "url" => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $user = auth()->user();
        $id = request()->id ?? 0;
        $title = request()->title ?? "";
        $url = request()->url ?? "";

        $menu = DB::table("menus")
            ->where("id", "=", $id)
            ->first();

        if ($menu == null)
        {
            return response()->json([
                "status" => "error",
                "message" => "Menu not found."
            ]);
        }

        $next_order = DB::table('menu_items')
            ->where('menu_id', $id)
            ->max('order') + 1;

        $obj = [
            "menu_id" => $id,
            "title" => $title,
            "url" => $url,
            "order" => $next_order,
            "created_at" => now()->utc(),
            "updated_at" => now()->utc(),
        ];

        $obj["id"] = DB::table("menu_items")
            ->insertGetId($obj);

        cache()->forget("menu_" . ($menu->name ?? ""));

        return response()->json([
            "status" => "success",
            "message" => "Menu item has been added.",
            "menu_item" => $obj
        ]);
    }

    public function add()
    {
        $validator = Validator::make(request()->all(), [
            "name" => "required"
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors([ "error" => $validator->errors()->first() ]);
        }

        $user = auth()->user();
        $name = request()->name ?? "";

        if (DB::table("menus")->where("name", "=", $name)->exists())
        {
            return redirect()->back()->withErrors([ "error" => "Menu with same name already exists." ]);
        }

        DB::table("menus")
            ->insertGetId([
                "name" => $name,
                "created_at" => now()->utc(),
                "updated_at" => now()->utc()
            ]);

        return redirect()->back()->with([ "success" => "Menu has been added." ]);
    }

    public function index()
    {
        $menu_id = (int) (request()->menu ?? 0);
        $menu_items = [];

        if ($menu_id > 0)
        {
            $menu_items = DB::table("menu_items")
                ->where("menu_id", "=", $menu_id)
                ->orderBy("order", "asc")
                ->get();
        }

        $menus = DB::table("menus")
            ->orderBy("name", "asc")
            ->get();

        return view("admin/menus/index", [
            "menus" => $menus,
            "menu_items" => $menu_items,
            "menu_id" => $menu_id
        ]);
    }
}
