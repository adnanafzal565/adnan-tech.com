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

        // Collect this item and all of its descendants
        // (not needed if parent_id has ON DELETE CASCADE, but harmless)
        $ids = [(int) $id];
        $queue = [(int) $id];

        while (!empty($queue))
        {
            $children = DB::table("menu_items")
                ->whereIn("parent_id", $queue)
                ->pluck("id")
                ->all();

            $ids = array_merge($ids, $children);
            $queue = $children;
        }

        DB::table("menu_items")
            ->whereIn("id", $ids)
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

        // Tree format: [{ "id": 1, "children": [{ "id": 2, "children": [] }] }, ...]
        $tree = json_decode(request()->order ?? "[]", true);

        if (!is_array($tree))
        {
            return response()->json([
                "status" => "error",
                "message" => "Invalid order data."
            ]);
        }

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

        // Only items that belong to this menu may be touched
        $validIds = DB::table("menu_items")
            ->where("menu_id", "=", $id)
            ->pluck("id")
            ->map(fn ($v) => (int) $v)
            ->all();

        $updates = [];
        $seen = [];

        $walk = function ($nodes, $parentId) use (&$walk, &$updates, &$seen, $validIds)
        {
            if (!is_array($nodes))
            {
                return;
            }

            foreach (array_values($nodes) as $index => $node)
            {
                $itemId = (int) ($node["id"] ?? 0);

                if (!in_array($itemId, $validIds, true) || isset($seen[$itemId]))
                {
                    continue;
                }

                $seen[$itemId] = true;
                $updates[] = [$itemId, $parentId, $index];

                $walk($node["children"] ?? [], $itemId);
            }
        };

        $walk($tree, null);

        DB::transaction(function () use ($updates)
        {
            foreach ($updates as [$itemId, $parentId, $index])
            {
                DB::table("menu_items")
                    ->where("id", "=", $itemId)
                    ->update([
                        "parent_id" => $parentId,
                        "order" => $index,
                        "updated_at" => now()->utc()
                    ]);
            }
        });

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

        $items = DB::table("menu_items")
            ->where("menu_id", $id)
            ->orderBy("order")
            ->get();

        // Group by parent (null parent => key 0)
        $byParent = $items->groupBy(fn ($i) => $i->parent_id ?? 0);

        // Build the tree recursively (any depth)
        $build = function ($parentId) use (&$build, $byParent)
        {
            return ($byParent[$parentId] ?? collect())->map(function ($item) use (&$build)
            {
                $item->children = $build($item->id);
                return $item;
            })->values();
        };

        return response()->json([
            "status" => "success",
            "message" => "Menu items has been fetched.",
            "items" => $build(0)
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
        $parent_id = request()->parent_id ? (int) request()->parent_id : null;

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

        // Parent (if given) must exist and belong to the same menu
        if ($parent_id !== null)
        {
            $parent_exists = DB::table("menu_items")
                ->where("id", "=", $parent_id)
                ->where("menu_id", "=", $id)
                ->exists();

            if (!$parent_exists)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "Parent item not found."
                ]);
            }
        }

        // Order among siblings (a null parent_id is compiled as IS NULL by the builder)
        $max_order = DB::table("menu_items")
            ->where("menu_id", $id)
            ->where("parent_id", $parent_id)
            ->max("order");

        $next_order = ($max_order === null) ? 0 : ((int) $max_order + 1);

        $obj = [
            "menu_id" => $id,
            "parent_id" => $parent_id,
            "title" => $title,
            "url" => $url,
            "order" => $next_order,
            "created_at" => now()->utc(),
            "updated_at" => now()->utc(),
        ];

        $obj["id"] = DB::table("menu_items")
            ->insertGetId($obj);

        $obj["children"] = [];

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