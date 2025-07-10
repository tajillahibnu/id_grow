<?php

namespace App\Application\Transfer\UseCase;

use App\Application\Transfer\DTOs\TransferDTO;
use App\Domain\Transfer\Entities\Transfer;
use App\Domain\Transfer\Repositories\TransferRepositoryInterface;
use App\Domain\Transfer\Services\KodeTransferService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTransfer
{
    public function __construct(
        private TransferRepositoryInterface $repo,
        protected KodeTransferService $kodeService,
    ) {}

    public function execute(TransferDTO $dto): array
    {
        return DB::transaction(function () use ($dto) {
            // $dto->data['kode_transfer'] = 'TRF-' . strtoupper(Str::random(6));
            $dto->data['kode_transfer'] = $this->kodeService->generateKode();
            $dto->data['status']        = 'draft';
            $dto->data['tanggal']       = now();

            $transfer = Transfer::fromDTO($dto);
            $saved = $this->repo->storeTransfer($transfer);
            $saved['produk'] = $this->repo->storeTransferDetails($saved['id'], $dto->extra['produk_details']);
            return $saved;
        });
    }
}
