<?php

namespace App\Interface\Http\Controllers\Api;

use App\Application\SatuanProduk\DTOs\SatuanProdukDTO;
use App\Application\SatuanProduk\UseCase\CreateSatuanProduk;
use App\Application\SatuanProduk\UseCase\DeleteSatuanProduk;
use App\Application\SatuanProduk\UseCase\GetSatuanProduk;
use App\Application\SatuanProduk\UseCase\GetSatuanProdukById;
use App\Application\SatuanProduk\UseCase\UpdateSatuanProduk;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Traits\IdCodec;
use Exception;
use Illuminate\Http\Request;

class SatuanProdukController extends Controller
{
    use ApiResponseTrait;
    use IdCodec;

    public function __construct(
        private GetSatuanProduk $getDataAll,
        private GetSatuanProdukById $getDataById,
        private CreateSatuanProduk $newData,
        private UpdateSatuanProduk $updateData,
        private DeleteSatuanProduk $deleteData,
    ) {}

    public function getAllData(Request $request)
    {
        try {
            $limit  = $request->query('limit', 10);
            $offset = $request->query('offset', 0);
            $sort   = $request->query('sort', 'asc');

            $limit = $limit === 'all' ? 'all' : min((int)$limit, 100);


            $items = $this->getDataAll->execute($limit, $offset, $sort);
            return $this->apiResponse($items['data'])
                ->addMeta($items['meta'])
                ->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function getDataById(string $id)
    {
        try {
            $id = $this->decodeId($id);

            $data = $this->getDataById->execute($id);
            return $this->apiResponse($data)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function newData(Request $request)
    {
        try {
            $dto = SatuanProdukDTO::forCreate($request);
            $storeData = $this->newData->execute($dto);
            return $this->apiResponse($storeData)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
    public function updateData(string $id, Request $request)
    {
        try {
            $id = $this->decodeId($id);

            $dto = SatuanProdukDTO::forUpdate($request, $id);
            $updateData = $this->updateData->execute($dto, $dto->id);
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

    public function deleteData(string $id)
    {
        try {
            $id = $this->decodeId($id);

            $storeData = $this->deleteData->execute($id);
            return $this->apiResponse($storeData)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
