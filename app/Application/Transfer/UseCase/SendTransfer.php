<?php

namespace App\Application\Transfer\UseCase;

use App\Domain\Mutasi\Services\MutasiService;
use App\Domain\ProdukLokasi\Repositories\ProdukLokasiRepositoryInterface;
use App\Domain\ProdukLokasi\Services\StokService;
use App\Domain\Transfer\Entities\Transfer;
use App\Domain\Transfer\Repositories\TransferRepositoryInterface;
use App\Domain\Transfer\Services\KodeTransferService;
use App\Infrastructure\Persistence\Eloquent\Models\Transfer as ModelsTransfer;
use App\Traits\IdCodec;
use Exception;
use Illuminate\Support\Facades\DB;

class SendTransfer
{
    use IdCodec;
    public function __construct(
        private TransferRepositoryInterface $repo,
        private MutasiService $mutasiService,
        private StokService $stokService,
        private ProdukLokasiRepositoryInterface $produkLokasiRepo,
        protected KodeTransferService $kodeService,
    ) {}


    public function execute(string|int $transferId, int $lokasi_tujuan_id): array
    {
        return DB::transaction(function () use ($transferId, $lokasi_tujuan_id) {
            $transfer = [];

            // Ambil transfer_keluar berdasarkan ID atau kode
            if (is_int($transferId)) {
                $transfer = $this->repo->getTransferById($transferId);
            } elseif (is_string($transferId)) {
                $transfer = $this->repo->getTransferByKode($transferId);
            }

            if (empty($transfer)) {
                throw new \Exception("Transfer tidak ditemukan.");
            }

            if ($transfer['tipe_transaksi'] !== 'transfer_keluar') {
                throw new \Exception('Transfer ini bukan tipe keluar.');
            }



            if ($transfer['status'] !== 'draft') {
                throw new \Exception("Transfer sudah dikirim atau tidak dalam status draft.");
            }

            $this->repo->updateTransfer($transfer['id'], ['status' => 'dikirim']);

            $produk_details = $this->repo->getTransferDetailById($transfer['id']);

            foreach ($produk_details as $detail) {
                $produkLokasi = $this->produkLokasiRepo->validateTersediaDanCukup(
                    $detail['produk_id'],
                    $transfer['lokasi_id'],
                    $detail['jumlah']
                );
                $this->mutasiService->createMutasiKeluar($transfer, $detail);
                $this->stokService->kurangiStok($detail['produk_id'], $transfer['lokasi_id'], $detail['jumlah']);
            }
            $this->transfer_masuk($transfer, $produk_details, $lokasi_tujuan_id);
            return $transfer;
        });
    }

    private function transfer_masuk($transfer, $produk_details, $lokasi_tujuan_id)
    {
        $parent_id = $transfer['parent_id'] ?? $transfer['id'];
        unset($transfer['id']);
        $dto = Transfer::fromDTO((object)$transfer);
        $dto->kode_transfer = $this->kodeService->generateKode();;
        $dto->parent_id         = $parent_id;
        $dto->lokasi_id         = $lokasi_tujuan_id;
        $dto->tipe_transaksi    = 'transfer_masuk';
        $dto->status            = 'draft';
        $dto->tanggal           = now();
        $saved = $this->repo->storeTransfer($dto);
        $this->repo->storeTransferDetails($saved['id'], $produk_details);
    }
}
