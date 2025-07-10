<?php

namespace App\Application\Auth\UseCase;

use App\Infrastructure\Persistence\Eloquent\Models\LoginLog;
use App\Infrastructure\Persistence\Eloquent\Models\LogLogin;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutTokenJwt
{
    public function execute(Request $request): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        $user = JWTAuth::user();

        LogLogin::create([
            'user_id'       => $user->id,
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
            'device'        => $this->detectDevice($request->userAgent()),
            'deskripsi'     => 'manual',
            'log_type'      => 'logout',
        ]);
    }

    private function detectDevice(string $userAgent): string
    {
        if (str_contains($userAgent, 'Mobile')) {
            return 'Mobile';
        } elseif (str_contains($userAgent, 'Tablet')) {
            return 'Tablet';
        }
        return 'Desktop';
    }
}
