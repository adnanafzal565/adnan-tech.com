<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "notifications";

    protected $fillable = [
        "user_id",
        "title",
        "content",
        "type",
        "table_id",
        "is_read"
    ];

    protected $casts = [
        "is_read" => "boolean"
    ];

    protected $appends = [
        "created_at_format"
    ];

    public function getCreatedAtFormatAttribute() {
        $value = $this->created_at ?? "";
        if ($value) {
            $value = date("d F, Y h:i:s A", strtotime($value));
        }
        return $value ?? '';
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function entity()
    {
        return match ($this->type) {
            "job_runner_job_created" => \App\Modules\JobRunner\Models\Job::find($this->table_id),
            default => null
        };
    }
}
