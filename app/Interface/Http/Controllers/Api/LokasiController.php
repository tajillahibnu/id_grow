<?php

namespace App\Interface\Http\Controllers\Api;

use App\Application\Lokasi\DTOs\LokasiDTO;
use App\Application\Lokasi\UseCase\CreateLokasi;
use App\Application\Lokasi\UseCase\DeleteLokasi;
use App\Application\Lokasi\UseCase\GetLokasi;
use App\Application\Lokasi\UseCase\GetLokasiById;
use App\Application\Lokasi\UseCase\UpdateLokasi;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Traits\IdCodec;
use Exception;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    use ApiResponseTrait;
    use IdCodec;

    public function __construct(
        private GetLokasi $getDataAll,
        private GetLokasiById $getDataById,
        private CreateLokasi $newData,
        private UpdateLokasi $updateData,
        private DeleteLokasi $deleteData,
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
            $dto = LokasiDTO::forCreate($request);
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

            $dto = LokasiDTO::forUpdate($request, $id);
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
