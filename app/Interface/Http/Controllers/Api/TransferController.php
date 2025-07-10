<?php

namespace App\Interface\Http\Controllers\Api;

use App\Application\Transfer\DTOs\TransferDTO;
use App\Application\Transfer\UseCase\CreateTransfer;
use App\Application\Transfer\UseCase\GetTransfer;
use App\Application\Transfer\UseCase\GetTransferById;
use App\Application\Transfer\UseCase\ReceiveTransfer;
use App\Application\Transfer\UseCase\SendTransfer;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Traits\IdCodec;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    use ApiResponseTrait;
    use IdCodec;

    public function __construct(
        private GetTransfer $getDataAll,
        private GetTransferById $getDataById,
    ) {}

    public function ditrima(Request $request, ReceiveTransfer $chek)
    {
        $user = Auth::user();

        try {
            $kode = $request->input('kode');
            $dto = TransferDTO::forCreate($request);
            $dto->data['user_id'] = $user->id;
            $data = $chek->execute($kode, $dto);
            return $this->apiResponse($data)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function kirim(Request $request, SendTransfer $kirim)
    {
        try {
            $kode = $request->input('kode');
            $lokasi_tujuan_id = $request->input('lokasi_tujuan_id');

            if (empty($kode)) {
                throw new Exception('Kode tidak boleh kosong.');
            }

            if (empty($lokasi_tujuan_id)) {
                throw new Exception('Tujuan lokasi tidak boleh kosong.');
            }

            $data = $kirim->execute($kode, $lokasi_tujuan_id);
            return $this->apiResponse($data)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function draft(Request $request, CreateTransfer $draft)
    {
        $user = Auth::user();
        try {
            $dto = TransferDTO::forCreate($request);
            $dto->data['user_id'] = $user->id;
            $data = $draft->execute($dto);
            return $this->apiResponse($data)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

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
}
