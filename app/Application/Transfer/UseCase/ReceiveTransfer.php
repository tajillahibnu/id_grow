<?php

namespace App\Application\Transfer\UseCase;

use App\Domain\Mutasi\Services\MutasiService;
use App\Domain\ProdukLokasi\Services\StokService;
use App\Domain\Transfer\Repositories\TransferRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class ReceiveTransfer
{
    public function __construct(
        private TransferRepositoryInterface $transferRepo,
        private MutasiService $mutasiService,
        private StokService $stokService,
    ) {}

    public function execute(int|string $transferId): array
    {
        return DB::transaction(function () use ($transferId) {
            /** @var Transfer $transfer */
            $transfer = is_numeric($transferId)
                ? $this->transferRepo->getTransferById($transferId, 'transfer_masuk')
                : $this->transferRepo->getTransferByKode($transferId, 'transfer_masuk');

            if (!$transfer || $transfer['tipe_transaksi'] !== 'transfer_masuk') {
                throw new Exception('Transfer tidak valid atau bukan tipe masuk.');
            }

            // if ($transfer['status'] !== 'check') {
            //     throw new Exception('Transfer tidak bisa diterima karena bukan dalam status check.');
            // }

            $details = $this->transferRepo->getTransferDetailById($transfer['id']);
            // $userPenerimaId = Auth::id(); 
            $userPenerimaId = 1;

            // Simpan mutasi & tambah stok
            foreach ($details as $detail) {
                if(empty($detail['mutasi_id'])){
                    $this->mutasiService->createMutasiMasuk((array) $transfer, $detail);
                    $this->stokService->tambahStok($detail['produk_id'], $transfer['lokasi_id'], $detail['jumlah']);
                }
            }

            // Update transfer masuk jadi selesai
            $this->transferRepo->updateTransfer($transfer['id'], [
                'status'         => 'selesai',
                'user_id'        => $userPenerimaId,
                'tanggal_terima' => now()->toDateString(),
            ]);

            return [
                'id'      => $transfer['id'],
                'status'  => 'selesai',
                'message' => 'Transfer berhasil diterima dan stok ditambahkan.',
            ];
        });
    }
}
