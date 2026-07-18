<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function destroy()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $user = auth()->user();
        $id = request()->id ?? 0;

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                "status" => "error",
                "message" => "Product does not exist."
            ]);
        }

        forget_products_cache();
        forget_product_cache($product->slug);

        $product->delete();

        return response()->json([
            "status" => "success",
            "message" => "Product has been moved to trash can."
        ]);
    }

    public function update()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required",
            "title" => "required",
            "slug" => "required",
            "active" => "required|in:0,1"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $user = auth()->user();
        $id = request()->id ?? 0;
        $title = request()->title ?? "";
        $slug = request()->slug ?? "";
        $price = ((int) request()->price ?? "0");
        $excerpt = request()->excerpt ?? "";
        $content = request()->content ?? "";
        $categories = request()->categories ?? [];
        $tags = request()->tags ?? "";
        $tags = array_filter(array_map("trim", explode(",", $tags)));
        $featured_image = request()->featured_image ?? 0;
        $active = (int) request()->active ?? 0;

        if (count($categories) > 0)
        {
            $dbCategoryNames = DB::table('categories')
                ->whereIn('name', $categories)
                ->pluck('name')
                ->toArray();

            // Normalize: lowercase and sort both
            $inputNormalized = array_map('strtolower', $categories);
            $dbNormalized = array_map('strtolower', $dbCategoryNames);

            sort($inputNormalized);
            sort($dbNormalized);

            $matched = ($inputNormalized === $dbNormalized);
            if (!$matched)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "In-valid category."
                ]);
            }
        }

        if (count($tags) > 0)
        {
            $dbTagNames = DB::table('tags')
                ->whereIn('name', $tags)
                ->pluck('name')
                ->toArray();

            // Normalize: lowercase and sort both
            $inputNormalized = array_map('strtolower', $tags);
            $dbNormalized = array_map('strtolower', $dbTagNames);

            sort($inputNormalized);
            sort($dbNormalized);

            $matched = ($inputNormalized === $dbNormalized);
            if (!$matched)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "In-valid tag."
                ]);
            }
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                "status" => "error",
                "message" => "Product does not exist."
            ]);
        }

        $image_id = 0;

        if ($featured_image > 0)
        {
            $file = DB::table("files")
                ->where("id", "=", $featured_image)
                ->where("type", "=", "public")
                ->first();

            if ($file == null)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "File not found."
                ]);
            }

            $image_id = $file->id;
        }

        $product_exists = Product::where("id", "!=", $id)
            ->where("slug", "=", $slug)
            ->exists();

        if ($product_exists) {
            return response()->json([
                "status" => "error",
                "message" => "Product with same slug already exists."
            ]);
        }

        $product->update([
            "title" => $title,
            "slug" => $slug,
            "excerpt" => $excerpt,
            "content" => $content,
            "categories" => $categories,
            "tags" => $tags,
            "image_id" => $image_id,
            "is_active" => $active,
        ]);

        forget_products_cache();
        forget_product_cache($product->slug);

        return response()->json([
            "status" => "success",
            "message" => "Product has been updated."
        ]);
    }

    public function edit()
    {
        $id = request()->id ?? 0;

        $product = Product::findOrFail($id);

        $categories = DB::table("categories")
            ->orderBy("name", "asc")
            ->pluck("name");

        $tags = DB::table("tags")
            ->orderBy("name", "asc")
            ->pluck("name");

        return view("admin/products/edit", [
            "product" => $product,
            "categories" => $categories,
            "tags" => $tags
        ]);
    }

    public function create()
    {
        $categories = DB::table("categories")
            ->orderBy("name", "asc")
            ->pluck("name");

        $tags = DB::table("tags")
            ->orderBy("name", "asc")
            ->pluck("name");

        return view("admin/products/create", [
            "categories" => $categories,
            "tags" => $tags,
        ]);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            "title" => "required",
            "slug" => "required",
            "active" => "required|in:0,1"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $user = auth()->user();
        $title = request()->title ?? "";
        $slug = request()->slug ?? "";
        $price = ((int) request()->price ?? "0");
        $excerpt = request()->excerpt ?? "";
        $content = request()->content ?? "";
        $categories = request()->categories ?? [];
        $tags = request()->tags ?? "";
        $tags = array_filter(array_map("trim", explode(",", $tags)));
        $featured_image = request()->featured_image ?? 0;
        $active = (int) (request()->active ?? 0);

        if (count($categories) > 0)
        {
            $dbCategoryNames = DB::table('categories')
                ->whereIn('name', $categories)
                ->pluck('name')
                ->toArray();

            // Normalize: lowercase and sort both
            $inputNormalized = array_map('strtolower', $categories);
            $dbNormalized = array_map('strtolower', $dbCategoryNames);

            sort($inputNormalized);
            sort($dbNormalized);

            $matched = ($inputNormalized === $dbNormalized);
            if (!$matched)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "In-valid category."
                ]);
            }
        }

        if (count($tags) > 0)
        {
            $dbTagNames = DB::table('tags')
                ->whereIn('name', $tags)
                ->pluck('name')
                ->toArray();

            // Normalize: lowercase and sort both
            $inputNormalized = array_map('strtolower', $tags);
            $dbNormalized = array_map('strtolower', $dbTagNames);

            sort($inputNormalized);
            sort($dbNormalized);

            $matched = ($inputNormalized === $dbNormalized);
            if (!$matched)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "In-valid tag."
                ]);
            }
        }

        $image_id = 0;

        if ($featured_image > 0)
        {
            $file = DB::table("files")
                ->where("id", "=", $featured_image)
                ->where("type", "=", "public")
                ->first();

            if ($file == null)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "File not found."
                ]);
            }

            $image_id = $file->id;
        }

        $product = Product::where("slug", "=", $slug)->first();

        if ($product) {
            return response()->json([
                "status" => "error",
                "message" => "Product with same slug already exists."
            ]);
        }

        $product = Product::create([
            "user_id" => $user->id,
            "title" => $title,
            "slug" => $slug,
            "price" => $price,
            "excerpt" => $excerpt,
            "content" => $content,
            "categories" => $categories,
            "tags" => $tags,
            "image_id" => $image_id,
            "is_active" => $active,
        ]);

        $product->update([
            'sku' => 'PROD-' . str_pad($product->id, 6, '0', STR_PAD_LEFT),
        ]);

        forget_products_cache();

        return response()->json([
            "status" => "success",
            "message" => "Product has been created.",
            "id" => $product->id
        ]);
    }

    public function admin_index()
    {
        set_timezone();

        $products = Product::orderBy("id", "desc")
            ->paginate(config("config.PER_PAGE"));

        return view("admin/products/index", [
            "products" => $products
        ]);
    }
}
