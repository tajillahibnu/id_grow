<?php

namespace App\Interface\Http\Actions\ProdukSerial;

use App\Application\ProdukSerial\UseCase\GetProdukSerialById;
use App\Traits\ApiResponseTrait;
use App\Traits\IdCodec;
use Exception;

class GetProdukSerialByIdAction
{
    use ApiResponseTrait;
    use IdCodec;

    public function __construct(
        private GetProdukSerialById $useCase
    ) {}

    /**
     * Get Data by ID
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

            $data = $this->useCase->execute($id);
            return $this->apiResponse($data)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}