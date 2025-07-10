<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class LogLogin extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'device',
        'os',
        'deskripsi',
        'log_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
