<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppRoles extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'name',
        'slug',
        'description',
    ];

    public function menus()
    {
        return $this->belongsToMany(AppMenu::class, 'app_menu_role', 'role_id', 'menu_id')->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(AppPermission::class, 'app_permission_roles', 'role_id', 'permission_id')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'app_role_users', 'role_id', 'user_id');
    }
}
