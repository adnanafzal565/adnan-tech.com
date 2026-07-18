<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $table = 'products';

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'sku',
        'price',
        'excerpt',
        'content',
        'categories',
        'tags',
        'image_id',
        'is_active',
    ];

    protected $casts = [
        'categories' => 'array',
        'tags' => 'array'
    ];

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
