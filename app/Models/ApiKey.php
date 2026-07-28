<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $table = "api_keys";

    protected $fillable = [
        "user_id",
        "name",
        "key",
        "status",
        "remaining",
        "last_used_at",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
