<?php

namespace App\Interface\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckPermissionMiddleware
{
    public function handle($request, Closure $next, string $baseSlug)
    {
        $claims = $request->attributes->get('jwt_claims');

        if (!$claims) {
            return response()->json(['message' => 'Token tidak valid atau klaim tidak tersedia.'], 401);
        }

        // ✅ Ambil slug dari active_role[0]
        $activeRole = $claims->get('active_role')[0] ?? null;
        $activeRoleSlug = $activeRole['slug'] ?? null;

        if (!$activeRoleSlug) {
            return response()->json(['message' => 'Slug peran aktif tidak ditemukan.'], 403);
        }

        // Ambil daftar permissions dari klaim berdasarkan active role
        $permissions = $claims->get('permissions') ?? [];

        // ✅ Ubah ke array jika belum pasti array
        $rolePermissions = (array) ($permissions[$activeRoleSlug] ?? []);

        // Slug spesifik dan umum
        $specificSlug = str_replace('.', '_', $baseSlug) . '_' . $activeRoleSlug; // e.g., update_kategori_produk_superadmin
        $generalSlug = $baseSlug;                                                 // e.g., update_kategori_produk

        // ✅ Cek apakah user punya salah satu permission
        if (!in_array($specificSlug, $rolePermissions) && !in_array($generalSlug, $rolePermissions)) {
            return response()->json([
                'message' => "Akses ditolak: tidak memiliki izin '$specificSlug' atau '$generalSlug'.",
            ], 403);
        }

        return $next($request);
    }
}
