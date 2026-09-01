<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Storage;

class Post extends Model
{
    use SoftDeletes;
    
    protected $table = "posts";

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'categories',
        'tags',
        'image_id',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'categories' => 'array',
        'tags' => 'array',
    ];

    protected $appends = [
        "updated_at_format",
    ];

    public function getUpdatedAtFormatAttribute() {
        $value = $this->updated_at ?? "";
        if ($value) {
            $value = date("M j, Y", strtotime($value));
        }
        return $value ?? '';
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id', 'id');
    }

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
