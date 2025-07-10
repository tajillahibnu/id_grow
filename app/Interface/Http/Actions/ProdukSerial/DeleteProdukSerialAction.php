<?php

namespace App\Interface\Http\Actions\ProdukSerial;

use App\Application\ProdukSerial\UseCase\DeleteProdukSerial;
use App\Traits\ApiResponseTrait;
use App\Traits\IdCodec;
use Exception;

class DeleteProdukSerialAction
{
    use ApiResponseTrait;
    use IdCodec;

    public function __construct(
        private DeleteProdukSerial $useCase
    ) {}

    /**
     * Delete Data
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
    public function __invoke(string $id)
    {
        try {
            $id = $this->decodeId($id);

            $storeData = $this->useCase->execute($id);
            return $this->apiResponse($storeData)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
