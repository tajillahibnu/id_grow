<?php

namespace App\Traits;

use App\Infrastructure\Services\IdEncoder;
use InvalidArgumentException;

/**
 * Trait IdCodec
 *
 * Trait ini menyediakan fungsi pembantu untuk melakukan encoding dan decoding ID
 * menggunakan service IdEncoder yang sudah kamu buat.
 * 
 * Cara pakai:
 * - Gunakan trait ini di class repository, service, controller, dll yang butuh encode/decode ID.
 * - Gunakan method encodeId(int $id): string untuk mengubah ID integer menjadi string terenkripsi.
 * - Gunakan method decodeId(string $encoded): int untuk mengubah string terenkripsi menjadi ID integer.
 *
 * Error Handling:
 * - Jika proses decode gagal (misal format string salah atau rusak), maka method decodeId
 *   akan melempar InvalidArgumentException dengan pesan yang jelas.
 *   Jadi pastikan untuk menangkap exception ini jika ada potensi input tidak valid.
 */
trait IdCodec
{
    /**
     * Instance IdEncoder yang digunakan untuk encode/decode.
     * Diinisialisasi hanya sekali via Laravel service container.
     *
     * @var IdEncoder
     */
    protected IdEncoder $idEncoderInstance;

    /**
     * Mendapatkan instance IdEncoder.
     * Memanfaatkan Laravel service container agar bisa di-mock saat testing.
     *
     * @return IdEncoder
     */
    protected function idEncoder(): IdEncoder
    {
        if (!isset($this->idEncoderInstance)) {
            $this->idEncoderInstance = app(IdEncoder::class);
        }
        return $this->idEncoderInstance;
    }

    /**
     * Encode ID integer ke string terenkripsi.
     *
     * @param int $id ID asli yang akan diencode
     * @return string ID terenkripsi dalam bentuk string
     */
    protected function encodeId(string|int $id): string
    {
        return $this->idEncoder()->encodeV2($id);
    }

    /**
     * Decode string terenkripsi menjadi ID integer.
     * Jika gagal decode, melempar InvalidArgumentException dengan pesan error yang jelas.
     *
     * @param string $encoded ID terenkripsi yang akan didecode
     * @return int ID asli hasil decode
     * @throws InvalidArgumentException Jika ID tidak valid atau rusak
     */
    protected function decodeId(string $encoded): int
    {
        try {
            return $this->idEncoder()->decodeV2($encoded);
        } catch (InvalidArgumentException $e) {
            // Berikan pesan error yang membantu debug
            throw new InvalidArgumentException("ID terenkripsi tidak valid atau rusak: " . $e->getMessage());
        }
    }
}
