<?php

namespace App\Interface\Http\Actions\ProdukSerial;

use App\Application\ProdukSerial\DTOs\ProdukSerialDTO;
use App\Application\ProdukSerial\UseCase\CreateProdukSerial;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class StoreProdukSerialAction
{
    use ApiResponseTrait;

    public function __construct(
        private CreateProdukSerial $useCase
    ) {}

    /**
     * New Data
     * @group Produk Serial
     * 
     * @response 401 {
     *   "message": "Request gagal diproses",
     *   "data": {},
     *   "success": false,
     *   "status": "error"
     * }
     * 
     * @response 200 {
     *   "message": "Request berhasil diproses",
     *   "data": {},
     *   "success": true,
     *   "status": "success"
     * }
     */
    public function __invoke(Request $request)
    {
        try {
            $dto = ProdukSerialDTO::forCreate($request);
            $storeData = $this->useCase->execute($dto);
            return $this->apiResponse($storeData)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
