<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value'
    ];

    public $timestamps = true;

    public function scopeGet_smtp($query)
    {
        $keys = [
            'smtp_host',
            'smtp_port',
            'smtp_encryption',
            'smtp_username',
            'smtp_password',
            'smtp_from',
            'smtp_from_name'
        ];

        $settings = $query->whereIn('key', $keys)
            ->get();

        $settings_arr = [];
        foreach ($settings as $setting)
            $settings_arr[$setting->key ?? ""] = $setting->value ?? "";

        return $settings_arr;
    }
}
