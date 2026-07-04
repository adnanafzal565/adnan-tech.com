<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutePermission extends Model
{
    protected $table = "route_permissions";

    protected $fillable = [
        'user_id',
        'route_name'
    ];
}
