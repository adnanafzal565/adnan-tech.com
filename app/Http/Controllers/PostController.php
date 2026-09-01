<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Storage;
use Validator;
use App\Models\Post;

class PostController extends Controller
{
    public function trash()
    {
        set_timezone();

        $posts = Post::onlyTrashed()
            ->orderBy("posts.id", "desc")
            ->paginate(config("config.PER_PAGE"));

        return view("admin/posts/trash", [
            "posts" => $posts
        ]);
    }

    public function delete_permanently()
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

        $post = Post::onlyTrashed()
            ->where("id", $id)
            ->first();

        if (!$post) {
            return response()->json([
                "status" => "error",
                "message" => "Post does not exist."
            ]);
        }

        forget_posts_cache();
        forget_post_cache($post->slug);

        $post->forceDelete();

        return response()->json([
            "status" => "success",
            "message" => "Post has been removed."
        ]);
    }

    public function restore()
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

        $post = Post::onlyTrashed()
            ->where("id", $id)
            ->first();

        if (!$post) {
            return response()->json([
                "status" => "error",
                "message" => "Post does not exist."
            ]);
        }

        $post->restore();

        forget_posts_cache();
        forget_post_cache($post->slug);

        return response()->json([
            "status" => "success",
            "message" => "Post has been restored."
        ]);
    }

    public function destroy()
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

        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                "status" => "error",
                "message" => "Post does not exist."
            ]);
        }

        forget_posts_cache();
        forget_post_cache($post->slug);

        $post->delete();

        return response()->json([
            "status" => "success",
            "message" => "Post has been moved to trash can."
        ]);
    }

    public function update()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required",
            "title" => "required",
            "slug" => "required"
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
        $slug = request()->slug ?? "";
        $excerpt = request()->excerpt ?? "";
        $content = request()->content ?? "";
        $categories = request()->categories ?? [];
        $tags = request()->tags ?? "";
        $tags = array_filter(array_map("trim", explode(",", $tags)));
        $featured_image = request()->featured_image ?? 0;
        $active = (int) request()->active ?? 0;
        $featured = (int) request()->featured ?? 0;

        if (!in_array($active, [0, 1]))
        {
            return response()->json([
                "status" => "error",
                "message" => "In-valid value for 'active'."
            ]);
        }

        if (!in_array($featured, [0, 1]))
        {
            return response()->json([
                "status" => "error",
                "message" => "In-valid value for 'featured'."
            ]);
        }

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

        $post = DB::table("posts")
            ->where("id", "=", $id)
            ->first();

        if ($post == null)
        {
            return response()->json([
                "status" => "error",
                "message" => "Post does not exist."
            ]);
        }

        if ($user->type !== "super_admin")
        {
            if ($post->user_id !== $user->id)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "Unauthorized."
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

        $post_exists = DB::table("posts")
            ->where("id", "!=", $post->id)
            ->where("slug", "=", $slug)
            ->exists();

        if ($post_exists)
        {
            return response()->json([
                "status" => "error",
                "message" => "Post with same slug already exists."
            ]);
        }

        DB::table("posts")
            ->where("id", "=", $post->id)
            ->update([
                "user_id" => $user->id,
                "title" => $title,
                "slug" => $slug,
                "excerpt" => $excerpt,
                "content" => $content,
                "categories" => json_encode($categories),
                "tags" => json_encode($tags),
                "image_id" => $image_id,
                "is_active" => $active,
                "is_featured" => $featured,
                "updated_at" => now()->utc()
            ]);

        forget_posts_cache();
        forget_post_cache($post->slug);
        forget_featured_post_cache();

        return response()->json([
            "status" => "success",
            "message" => "Post has been updated."
        ]);
    }

    public function edit()
    {
        $id = request()->id ?? 0;

        $post = DB::table("posts")
            ->select("posts.*", "files.file_path")
            ->leftJoin("files", "files.id", "=", "posts.image_id")
            ->where("posts.id", "=", $id)
            ->first();

        if ($post == null)
        {
            abort(404);
        }

        $post = Post::map($post);

        $categories = DB::table("categories")
            ->orderBy("name", "asc")
            ->pluck("name");

        $tags = DB::table("tags")
            ->orderBy("name", "asc")
            ->pluck("name");

        return view("admin/posts/edit", [
            "post" => $post,
            "categories" => $categories,
            "tags" => $tags
        ]);
    }

    public function add()
    {
        if (request()->isMethod("post"))
        {
            $validator = Validator::make(request()->all(), [
                "title" => "required",
                "slug" => "required"
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
            $excerpt = request()->excerpt ?? "";
            $content = request()->content ?? "";
            $categories = request()->categories ?? [];
            $tags = request()->tags ?? "";
            $tags = array_filter(array_map("trim", explode(",", $tags)));
            $featured_image = request()->featured_image ?? 0;
            $active = (int) (request()->active ?? 0);
            $featured = (int) (request()->featured ?? 0);

            if (!in_array($active, [0, 1]))
            {
                return response()->json([
                    "status" => "error",
                    "message" => "In-valid value for 'active'."
                ]);
            }

            if (!in_array($featured, [0, 1]))
            {
                return response()->json([
                    "status" => "error",
                    "message" => "In-valid value for 'featured'."
                ]);
            }

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

            $post = DB::table("posts")
                ->where("slug", "=", $slug)
                ->first();

            if ($post != null)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "Post with same slug already exists."
                ]);
            }

            $id = DB::table("posts")
                ->insertGetId([
                    "user_id" => $user->id,
                    "title" => $title,
                    "slug" => $slug,
                    "excerpt" => $excerpt,
                    "content" => $content,
                    "categories" => json_encode($categories),
                    "tags" => json_encode($tags),
                    "image_id" => $image_id,
                    "is_active" => $active,
                    "is_featured" => $featured,
                    "created_at" => now()->utc(),
                    "updated_at" => now()->utc()
                ]);

            forget_posts_cache();

            return response()->json([
                "status" => "success",
                "message" => "Post has been created.",
                "id" => $id
            ]);
        }
        
        $categories = DB::table("categories")
            ->orderBy("name", "asc")
            ->pluck("name");

        $tags = DB::table("tags")
            ->orderBy("name", "asc")
            ->pluck("name");

        return view("admin/posts/add", [
            "categories" => $categories,
            "tags" => $tags,
        ]);
    }

    public function index()
    {
        set_timezone();

        $posts = Post::with(["user"])
            ->orderBy("id", "desc")
            ->paginate(config("config.PER_PAGE"));

        return view("theme::posts/index", [
            "posts" => $posts
        ]);
    }

    public function admin_index()
    {
        set_timezone();

        $posts = Post::orderBy("id", "desc")
            ->paginate(config("config.PER_PAGE"));

        return view("admin/posts/index", [
            "posts" => $posts
        ]);
    }
}
