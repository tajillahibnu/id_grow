<?php

namespace App\Interface\Http\Actions\ProdukSerial;

use App\Application\ProdukSerial\DTOs\ProdukSerialDTO;
use App\Application\ProdukSerial\UseCase\UpdateProdukSerial;
use App\Traits\ApiResponseTrait;
use App\Traits\IdCodec;
use Exception;
use Illuminate\Http\Request;

class UpdateProdukSerialAction
{
    use ApiResponseTrait;
    use IdCodec;

    public function __construct(
        private UpdateProdukSerial $useCase
    ) {}

    /**
     * Update Data
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
    public function __invoke(string $id, Request $request)
    {
        try {
            $id = $this->decodeId($id);

            $dto = ProdukSerialDTO::forUpdate($request, $id);
            $updateData = $this->useCase->execute($dto, $dto->id);
            return $this->apiResponse($updateData)->send();
        } catch (\InvalidArgumentException $e) {
            return $this->handleException($e);
        } catch (\Exception $e) {
            return $this->apiResponse([])
                ->setMessage('Terjadi kesalahan pada server')
                ->setCode(500)
                ->send();
        }
    }
}
