<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormAttempt extends Model
{
    protected $table = "form_attempts";

    protected $fillable = [
        "token",
        "form_type",
        "started_at",
    ];

    protected $casts = [
        "started_at" => "datetime",
    ];
}
