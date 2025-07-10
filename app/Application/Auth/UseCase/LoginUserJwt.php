<?php

namespace App\Application\Auth\UseCase;

use App\Application\User\DTOs\LoginUserDTO;
use App\Infrastructure\Persistence\Eloquent\Models\LoginLog;
use App\Infrastructure\Persistence\Eloquent\Models\LogLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUserJwt
{
    public function execute(LoginUserDTO $dto, Request $request)
    {
        $credentials = [
            'email' => $dto->email,
            'password' => $dto->password,
        ];
        if (!$token = JWTAuth::attempt($credentials)) {
            // throw new \Exception('Invalid credentials');
            return [
                'status'    => 500,
                'message'   => 'Login gagal, email dan password salah.',
                'data'      => []
            ];
        }

        $user = JWTAuth::user();
        $primaryRole = $user->primaryRole()->get();
        // // dd($user);
        // dd($roles);
        // exit;

        // Cek role utama (misal berdasarkan pivot is_primary)
        // $primaryRole = $user->roles()->wherePivot('is_primary', true)->first()
        //     ?? $user->roles()->first(); // fallback

        $roles = $user->roles()->get();

        $rolesSlugs = $roles->pluck('slug')->toArray();
        $roleUsers = $user->roles()->with('permissions')->get();

        // // Buat array permission per role
        $permissions = [];
        foreach ($roleUsers as $role) {
            $permissions[$role->slug] = str_replace(
                '~|role|~',
                $role->slug,
                $role->permissions->pluck('slug')->toArray()
            );
        }

        // Generate ulang token dengan claims
        $token = JWTAuth::claims([
            'roles' => $rolesSlugs,
            'lokasi_id' => $user->lokasi_id,
            'permissions' => $permissions,
            'active_role' => $primaryRole,
        ])->attempt($credentials);

        if (!$token) {
            return [
                'status'    => 401,
                'message'   => 'Login gagal, token tidak dibuat.',
                'data'      => []
            ];
        }

        // Simpan log login
        LogLogin::create([
            'user_id'    => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            // 'device'     => $this->detectDevice($agent),
            // 'os'         => $agent->platform() ?? 'Unknown',
            'log_type'   => 'login',
            'login_type' => 'manual',
        ]);

        $rolesFormatted = $roles->map(function ($roleUser) {
            return [
                'id' => $roleUser->id,
                'kode' => $roleUser->kode,
                'slug' => $roleUser->slug,
                'name' => $roleUser->name,
                'description' => $roleUser->description,
                'is_primary' => $roleUser->pivot->is_primary ?? false,
            ];
        });

        return [
            'status'    => 200,
            'message'   => 'Login berhasil',
            'data'      => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'active_role' => $rolesSlugs,
                // 'user' => [
                //     'username' => $user->username,
                //     'email' => $user->email,
                //     // 'roles' => $rolesFormatted,
                // ],
            ]
        ];
    }

    // private function detectDevice(Agent $agent): string
    // {
    //     if ($agent->isTablet()) {
    //         return 'Tablet';
    //     } elseif ($agent->isMobile()) {
    //         return 'Mobile';
    //     }
    //     return 'Desktop';
    // }
}
