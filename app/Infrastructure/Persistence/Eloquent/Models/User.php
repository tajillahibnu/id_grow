<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = ['password'];

    /**
     * Mendapatkan ID unik untuk JWT
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Biasanya ID pengguna
    }

    /**
     * Mendapatkan klaim untuk payload JWT
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(AppRoles::class, 'app_role_users', 'user_id', 'role_id')->withPivot('is_primary');
    }

    public function primaryRole()
    {
        return $this->belongsTo(AppRoles::class, 'primary_role_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
}
