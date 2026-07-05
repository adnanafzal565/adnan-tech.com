<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'type',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $appends = [
        "created_at_format",
        "deleted_at_format",
    ];

    public function getDeletedAtFormatAttribute() {
        $value = $this->deleted_at ?? "";
        if ($value) {
            $value = date("d F, Y", strtotime($value));
        }
        return $value ?? '';
    }

    public function getCreatedAtFormatAttribute() {
        $value = $this->created_at ?? "";
        if ($value) {
            $value = date("d F, Y", strtotime($value));
        }
        return $value ?? '';
    }

    public static function map($user)
    {
        if ($user == null)
        {
            return null;
        }

        $obj = [
            "id" => $user->id ?? 0,
            "name" => $user->name ?? "",
            "email" => $user->email ?? "",
            "profile_image" => $user->profile_image ?? "",
            "type" => $user->type ?? "",
            "is_block" => $user->is_block ?? 0,
            "created_at" => date("d M, Y h:i:s a", strtotime($user->created_at . " UTC"))
        ];

        if ($obj["profile_image"] && Storage::exists("public/" . $obj["profile_image"]))
        {
            $obj["profile_image"] = url("/storage/" . $obj["profile_image"]);
        }

        return (object) $obj;
    }

    public function is_super_admin(): bool
    {
        return $this->type === 'super_admin';
    }

    public function has_route_access(string $route_name): bool
    {
        if ($this->is_super_admin()) {
            return true;
        }

        return in_array($route_name, $this->allowed_routes(), true);
    }

    public function route_permissions()
    {
        return $this->hasMany(RoutePermission::class, 'user_id', 'id');
    }

    public function allowed_routes()
    {
        return $this->route_permissions()
            ->pluck('route_name')
            ->toArray();
    }
}
