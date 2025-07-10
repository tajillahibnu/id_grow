<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'menu_id'
    ];

    // Relasi ke menu (optional)
    public function menu()
    {
        return $this->belongsTo(AppMenu::class, 'menu_id');
    }

    // Relasi ke roles (many-to-many)
    public function roles()
    {
        return $this->belongsToMany(AppRoles::class, 'app_permission_roles', 'permission_id', 'role_id')->withTimestamps();
    }
}
