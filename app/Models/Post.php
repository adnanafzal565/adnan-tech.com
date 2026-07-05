<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Storage;

class Post extends Model
{
    use SoftDeletes;
    
    protected $table = "posts";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function map($post)
    {
        if ($post == null)
        {
            return null;
        }

        $post->title = $post->title ?? "";
        $post->excerpt = $post->excerpt ?? "";
        $post->content = $post->content ?? "";
        $post->categories = json_decode($post->categories ?? "[]");
        $post->tags = json_decode($post->tags ?? "[]");

        if (isset($post->file_path) && Storage::exists("public/" . $post->file_path))
        {
            $post->file_path = url("/storage/" . $post->file_path);
        }

        $post->created_at_formatted = date("d F, Y", strtotime($post->created_at . " UTC"));
        $post->url = url("/" . ($post->slug ?? ""));
        return $post;
    }
}
