<?php

use App\Interface\Http\Controllers\Api\HistoryController;
use App\Interface\Http\Controllers\Api\JenisMutasiController;
use App\Interface\Http\Controllers\Api\KategoriProdukController;
use App\Interface\Http\Controllers\Api\LokasiController;
use App\Interface\Http\Controllers\Api\MemberController;
use App\Interface\Http\Controllers\Api\ProdukController;
use App\Interface\Http\Controllers\Api\SatuanProdukController;
use App\Interface\Http\Controllers\Api\TransferController;
use App\Interface\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::group(['prefix' => 'auth', 'middleware' => []], function () {
//     Route::post('do_login', [MemberController::class, 'doLogin'])->name('do_login');
//     Route::middleware(['auth:api', 'jwt.claims'])->group(function () {
//         Route::get('me', [≈::class, 'getMe'])->name('me');
//         Route::get('logout', [MemberController::class, 'logout']);
//     });
// });

Route::controller(MemberController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('/', 'doLogin');
        Route::post('/me', 'getMe')->middleware(['auth:api', 'jwt.claims']);
        Route::post('/logout', 'logout')->middleware(['auth:api', 'jwt.claims']);
    });

// >>> AUTO-GENERATED ROUTES START <<<

Route::controller(LokasiController::class)
    ->middleware(['auth:api', 'jwt.claims'])
    ->prefix('lokasi')
    ->group(function () {
        Route::get('/', 'getAllData')->middleware('check.permission:read_lokasi');;
        Route::get('/{id}', 'getDataById')->middleware('check.permission:read_lokasi');;
        Route::post('/', 'newData')->middleware('check.permission:store_lokasi');;
        Route::post('/update/{id}', 'updateData')->middleware('check.permission:update_lokasi');;
        Route::post('/delete/{id}', 'deleteData')->middleware('check.permission:delete_lokasi');;
    });

Route::controller(KategoriProdukController::class)
    ->middleware(['auth:api', 'jwt.claims'])
    ->prefix('kategori-produk')
    ->group(function () {
        Route::get('/', 'getAllData')->middleware('check.permission:read_kategori_produk');
        Route::get('/{id}', 'getDataById')->middleware('check.permission:read_kategori_produk');
        Route::post('/', 'newData')->middleware('check.permission:store_kategori_produk');
        Route::post('/update/{id}', 'updateData')->middleware('check.permission:update_kategori_produk');
        Route::post('/delete/{id}', 'deleteData')->middleware('check.permission:delete_kategori_produk');
    });

Route::controller(SatuanProdukController::class)
    ->middleware(['auth:api', 'jwt.claims'])
    ->prefix('satuan-produk')
    ->group(function () {
        Route::get('/', 'getAllData')->middleware('check.permission:read_satuan_produk');
        Route::get('/{id}', 'getDataById')->middleware('check.permission:read_satuan_produk');
        Route::post('/', 'newData')->middleware('check.permission:store_satuan_produk');
        Route::post('/update/{id}', 'updateData')->middleware('check.permission:update_satuan_produk');
        Route::post('/delete/{id}', 'deleteData')->middleware('check.permission:delete_satuan_produk');
    });

Route::controller(JenisMutasiController::class)
    ->middleware(['auth:api', 'jwt.claims'])
    ->prefix('jenis-mutasi')
    ->group(function () {
        Route::get('/', 'getAllData')->middleware('check.permission:read_jenis_mutasi');
        Route::get('/{id}', 'getDataById')->middleware('check.permission:read_jenis_mutasi');
        Route::post('/', 'newData')->middleware('check.permission:store_jenis_mutasi');
        Route::post('/update/{id}', 'updateData')->middleware('check.permission:update_jenis_mutasi');
        Route::post('/delete/{id}', 'deleteData')->middleware('check.permission:delete_jenis_mutasi');
    });

Route::controller(ProdukController::class)
    ->middleware(['auth:api', 'jwt.claims'])
    ->prefix('produk')
    ->group(function () {
        Route::get('/', 'getAllData')->middleware('check.permission:read_produk');
        Route::get('/{id}', 'getDataById')->middleware('check.permission:read_produk');
        Route::post('/', 'newData')->middleware('check.permission:store_produk');
        Route::post('/update/{id}', 'updateData')->middleware('check.permission:update_produk');
        Route::post('/delete/{id}', 'deleteData')->middleware('check.permission:delete_produk');
    });

Route::controller(UserController::class)
    ->middleware(['auth:api', 'jwt.claims'])
    ->prefix('user')
    ->group(function () {
        Route::get('/', 'getAllData')->middleware('check.permission:read_user');
        Route::get('/{id}', 'getDataById')->middleware('check.permission:read_user');
        Route::post('/', 'newData')->middleware('check.permission:store_user');
        Route::post('/update/{id}', 'updateData')->middleware('check.permission:update_user');
        Route::post('/delete/{id}', 'deleteData')->middleware('check.permission:delete_user');
    });

Route::controller(TransferController::class)
    ->middleware(['auth:api', 'jwt.claims'])
    ->prefix('transfer')
    ->group(function () {
        Route::get('/', 'getAllData');
        Route::get('/{id}', 'getDataById');
        Route::post('/', 'draft');
        Route::post('/kirim', 'kirim');
        Route::post('/trima', 'ditrima');
    });

Route::controller(HistoryController::class)
    // ->middleware(['auth:api', 'jwt.claims'])
    ->prefix('produk')
    ->group(function () {
        Route::get('{produk}/mutasi', 'historyByProduk');
    });

Route::controller(HistoryController::class)
    // ->middleware(['auth:api', 'jwt.claims'])
    ->prefix('user')
    ->group(function () {
        Route::get('{user}/mutasi', 'historyByUser');
    });

Route::prefix('produk-serial')
    // ->middleware(['auth:api', 'jwt.claims'])
    ->group(function () {
        Route::get('/', [App\Interface\Http\Actions\ProdukSerial\GetProdukSerialAction::class, '__invoke']);
        Route::get('/{id}', [App\Interface\Http\Actions\ProdukSerial\GetProdukSerialByIdAction::class, '__invoke']);
        Route::post('/', [App\Interface\Http\Actions\ProdukSerial\StoreProdukSerialAction::class, '__invoke']);
        Route::post('/update/{id}', [App\Interface\Http\Actions\ProdukSerial\UpdateProdukSerialAction::class, '__invoke']);
        Route::post('/delete/{id}', [App\Interface\Http\Actions\ProdukSerial\DeleteProdukSerialAction::class, '__invoke']);
    });
// >>> AUTO-GENERATED ROUTES END <<<
