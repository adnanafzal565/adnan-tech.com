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

    protected $casts = [
        "last_used_at" => "datetime"
    ];

    protected $appends = [
        "last_used_at_format"
    ];

    public function getLastUsedAtFormatAttribute()
    {
        $value = $this->last_used_at ?? "";
        if ($value) {
            $value = date("d F, Y h:i:s a", strtotime($value));
        }
        return $value ?? '';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
