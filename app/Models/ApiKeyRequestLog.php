<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKeyRequestLog extends Model
{
    protected $table = "api_key_request_logs";

    protected $fillable = [
        "api_key_id",
        "title",
        "content",
        "device",
        "ip",
        "remaining"
    ];

    protected $casts = [
        "device" => "array"
    ];

    public function api_key()
    {
        return $this->belongsTo(ApiKey::class, "api_key_id", "id");
    }
}
