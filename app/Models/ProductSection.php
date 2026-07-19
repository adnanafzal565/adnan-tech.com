<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSection extends Model
{
    protected $table = 'product_sections';

    protected $fillable = [
        'product_id',
        'title',
        'description',
        'type',
        'url'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
