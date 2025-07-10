<?php

namespace App\Interface\Http\Actions\ProdukSerial;

use App\Application\ProdukSerial\UseCase\GetProdukSerial;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Exception;

class GetProdukSerialAction
{
    use ApiResponseTrait;

    public function __construct(
        private GetProdukSerial $useCase
    ) {}

    /**
     * Get All Data
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
     *   "meta": {
     *     "limit": 10,
     *     "offset": 10,
     *     "sort": "desc",
     *     "count": 10,
     *     "total": 50
     *   },
     *   "success": true,
     *   "status": "success"
     * }
     */
    public function __invoke(Request $request)
    {
        try {
            $limit  = $request->query('limit', 10);
            $offset = $request->query('offset', 0);
            $sort   = $request->query('sort', 'asc'); // asc atau desc

            $limit = $limit === 'all' ? 'all' : min((int)$limit, 100); // maksimal 100 item


            $items = $this->useCase->execute($limit, $offset, $sort);
            return $this->apiResponse($items['data'])
                ->addMeta($items['meta'])
                ->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
