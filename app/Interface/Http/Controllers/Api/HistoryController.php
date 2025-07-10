<?php

namespace App\Interface\Http\Controllers\Api;

use App\Application\Mutasi\UseCase\GetMutasiHistoryByProduk;
use App\Application\Mutasi\UseCase\GetMutasiHistoryByUser;
use App\Application\Transfer\UseCase\GetTransferById;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Traits\IdCodec;
use Exception;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    use ApiResponseTrait;
    use IdCodec;

    public function __construct(
        private GetMutasiHistoryByProduk $produk,
        private GetMutasiHistoryByUser $user,
    ) {}

    public function historyByProduk(string $id)
    {
        try {
            $id = $this->decodeId($id);

            $data = $this->produk->execute($id);
            return $this->apiResponse($data)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function historyByUser(string $id)
    {
        try {
            $id = $this->decodeId($id);

            $data = $this->user->execute($id);
            return $this->apiResponse($data)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
