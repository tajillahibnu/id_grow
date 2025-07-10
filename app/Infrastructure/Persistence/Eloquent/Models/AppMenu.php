<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class AppMenu extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'url',
        'route',
        'view_path',
        'view_file',
        'is_global',
        'is_aktif',
        'tipe',
        'level',
        'order',
    ];

    // Relasi ke parent menu (untuk menu tree)
    public function parent()
    {
        return $this->belongsTo(AppMenu::class, 'parent_id');
    }

    // Relasi ke anak menu (sub menu)
    public function children()
    {
        return $this->hasMany(AppMenu::class, 'parent_id');
    }

    // Relasi ke roles (many-to-many)
    public function roles()
    {
        return $this->belongsToMany(AppRoles::class, 'app_menu_role', 'menu_id', 'role_id')->withTimestamps();
    }
}
