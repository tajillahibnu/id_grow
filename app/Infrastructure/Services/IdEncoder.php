<?php

namespace App\Infrastructure\Services;

use InvalidArgumentException;

/**
 * Class IdEncoder
 *
 * Encode dan decode ID menggunakan AES-128-ECB + Base62.
 * Diperlukan AES key sepanjang 16 karakter.
 */
class IdEncoder
{
    private const ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    private string $aesKey;

    /**
     * @param string $aesKey Kunci AES harus 16 karakter
     * @throws InvalidArgumentException
     */
    public function __construct(string $aesKey)
    {
        if (strlen($aesKey) !== 16) {
            throw new InvalidArgumentException("AES key harus 16 karakter.");
        }
        $this->aesKey = $aesKey;
    }

    /**
     * Encode ID integer menjadi string terenkripsi.
     * @param int $id
     * @return string
     */
    public function encode(int $id): string
    {
        return $this->encodeAES($id);
    }

    /**
     * Decode string terenkripsi menjadi ID integer.
     * @param string $encoded
     * @return int
     * @throws InvalidArgumentException
     */
    public function decode(string $encoded): int
    {
        return $this->decodeAES($encoded);
    }

    /**
     * Versi baru encode dengan random code.
     * @param mixed $id
     * @return string
     */
    public function encodeV2(mixed $id): string
    {
        $randomCode = \Illuminate\Support\Str::random(2);
        $toEncode = "{$id}~||code||~{$randomCode}";
        return $this->encodeAESString($toEncode);
    }

    /**
     * Decode hasil dari encodeV2, ambil ID asli.
     * @param string $encoded
     * @return string
     * @throws InvalidArgumentException
     */
    public function decodeV2(string $encoded): string
    {
        $decoded = $this->decodeAESString($encoded);
        $parts = explode('~||code||~', $decoded);

        if (count($parts) !== 2) {
            throw new InvalidArgumentException("Format ID tidak valid.");
        }

        return $parts[0];
    }

    private function encodeAES(int $id): string
    {
        $encrypted = openssl_encrypt((string)$id, 'AES-128-ECB', $this->aesKey, OPENSSL_RAW_DATA);
        if ($encrypted === false) {
            throw new \RuntimeException("Enkripsi gagal.");
        }
        return $this->toBase62($encrypted);
    }

    private function decodeAES(string $encoded): int
    {
        $encrypted = $this->fromBase62($encoded);
        $decrypted = openssl_decrypt($encrypted, 'AES-128-ECB', $this->aesKey, OPENSSL_RAW_DATA);

        if ($decrypted === false || !ctype_digit($decrypted)) {
            throw new InvalidArgumentException("ID tidak valid atau rusak.");
        }

        return (int)$decrypted;
    }

    private function encodeAESString(string $data): string
    {
        $encrypted = openssl_encrypt($data, 'AES-128-ECB', $this->aesKey, OPENSSL_RAW_DATA);
        if ($encrypted === false) {
            throw new \RuntimeException("Enkripsi gagal.");
        }
        return $this->toBase62($encrypted);
    }

    private function decodeAESString(string $encoded): string
    {
        $encrypted = $this->fromBase62($encoded);
        $decrypted = openssl_decrypt($encrypted, 'AES-128-ECB', $this->aesKey, OPENSSL_RAW_DATA);

        if ($decrypted === false) {
            throw new InvalidArgumentException("ID tidak valid atau rusak.");
        }

        return $decrypted;
    }

    private function toBase62(string $data): string
    {
        $num = gmp_init(bin2hex($data), 16);
        $base = strlen(self::ALPHABET);
        $out = '';

        while (gmp_cmp($num, 0) > 0) {
            list($num, $rem) = gmp_div_qr($num, $base);
            $out = self::ALPHABET[gmp_intval($rem)] . $out;
        }

        return $out ?: '0';
    }

    private function fromBase62(string $str): string
    {
        $base = strlen(self::ALPHABET);
        $num = gmp_init(0);

        for ($i = 0; $i < strlen($str); $i++) {
            $pos = strpos(self::ALPHABET, $str[$i]);
            if ($pos === false) {
                throw new InvalidArgumentException("Karakter tidak valid pada ID.");
            }
            $num = gmp_add(gmp_mul($num, $base), $pos);
        }

        $hex = gmp_strval($num, 16);
        if (strlen($hex) % 2 !== 0) {
            $hex = '0' . $hex;
        }

        return hex2bin($hex);
    }
}
