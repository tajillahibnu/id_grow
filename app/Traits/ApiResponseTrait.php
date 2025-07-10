<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\QueryException;

trait ApiResponseTrait
{
    protected $response = [];
    protected $statusCode = 200;
    protected array $meta = [];

    // Pesan default untuk sukses dan error
    protected $defaultSuccessMessage = 'Request berhasil diproses';
    protected $defaultErrorMessage = 'Terjadi kesalahan pada server';

    /**
     * Atur data awal untuk API response.
     *
     * @param mixed $data
     * @return self
     */
    public function apiResponse($data = null)
    {
        // Jika ada statusCode atau message di data, atur ke response dan hapus dari data utama
        if (is_array($data)) {
            if (isset($data['statusCode'])) {
                $this->statusCode = $data['statusCode'];
                unset($data['statusCode']);
            }

            if (isset($data['message'])) {
                $this->response['message'] = $data['message'];
                unset($data['message']);
            }
        }

        // Jika tidak ada pesan, set pesan default berdasarkan statusCode
        if (!isset($this->response['message'])) {
            $this->response['message'] = $this->statusCode >= 200 && $this->statusCode < 300
                ? $this->defaultSuccessMessage
                : $this->defaultErrorMessage;
        }

        // Atur data ke response
        $this->response['data'] = $this->sanitizeResponseData($data);

        // Set success dan status berdasarkan statusCode
        $this->response['success'] = $this->statusCode >= 200 && $this->statusCode < 300;
        $this->response['status'] = $this->statusCode >= 200 && $this->statusCode < 300 ? 'success' : 'error';

        return $this;
    }

    /**
     * Tambahkan pesan ke respons.
     *
     * @param string $message
     * @return self
     */
    public function setMessage(string $message)
    {
        $this->response['message'] = $message;
        return $this;
    }

    public function addMeta(array $meta): static
    {
        $this->meta = $meta;
        return $this;
    }


    /**
     * Tambahkan detail error jika ada.
     *
     * @param mixed $errors
     * @return self
     */
    public function errors($errors)
    {
        $this->response['errors'] = $errors;
        $this->response['success'] = false; // Set success ke false jika ada errors
        $this->response['status'] = 'error';
        return $this;
    }

    /**
     * Atur status kode HTTP.
     *
     * @param int $code
     * @return self
     */
    public function setCode(int $code)
    {
        $this->statusCode = $code;

        // Tentukan success dan status berdasarkan kode
        $this->response['success'] = $code >= 200 && $code < 300;
        $this->response['status'] = $code >= 200 && $code < 300 ? 'success' : 'error';

        return $this;
    }

    /**
     * Kirim respons sebagai JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send()
    {
        if (!empty($this->meta)) {
            $this->response['meta'] = $this->meta;
        }

        return response()->json($this->response, $this->statusCode);
    }

    /**
     * Sanitasi data respons untuk menghindari struktur ['data']['data'].
     *
     * @param mixed $data
     * @return mixed
     */
    protected function sanitizeResponseData($data)
    {
        if (is_array($data) && isset($data['data']) && is_array($data['data'])) {
            return $data['data']; // Ambil data dalamnya
        }

        return $data;
    }

    /**
     * Tangani exception dan format respons error.
     *
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleException(Exception $e)
    {
        if ($e instanceof QueryException) {
            return $this->handleQueryException($e);
        }
        return $this->handleGenericException($e);
    }

    protected function handleQueryException(QueryException $e)
    {
        $message = $e->getMessage();

        if (str_contains($message, 'Duplicate entry')) {
            return $this->handleDuplicateEntry($message);
        }

        if (str_contains($message, 'SQLSTATE[42S22]')) {
            return $this->handleMissingColumn($message);
        }

        if (str_contains($message, 'SQLSTATE[42S02]')) {
            return $this->handleTableNotFound($message);
        }

        if (str_contains($message, "doesn't have a default value")) {
            return $this->handleMissingDefaultValue($message);
        }

        if (str_contains($message, 'Incorrect date value')) {
            return $this->handleInvalidDateFormat($message);
        }


        if (str_contains($message, 'cannot be null')) {
            return $this->handleNotNullableColumn($message);
        }

        return $this->handleGenericException($e);
    }

    protected function handleGenericException(Exception $e)
    {
        $isDebug = config('app.debug');
        $code = $e->getCode();
        $statusCode = ($code >= 100 && $code < 600) ? $code : 500;

        $response = [
            'message' => $isDebug
                ? ($e->getMessage() ?: $this->defaultErrorMessage)
                : $this->defaultErrorMessage,
            'errors' => $isDebug
                ? ['detail' => $e->getTrace()]
                : [],
        ];

        return $this->apiResponse()
            ->setCode($statusCode)
            ->setMessage($response['message'])
            ->errors($response['errors'])
            ->send();
    }




    protected function handleDuplicateEntry(string $message)
    {
        $isDebug = config('app.debug');
        $fieldName = $this->parseDuplicateKey($message);

        $response = [
            'message' => "Data sudah ada (duplikat): {$fieldName}.",
            'errors' => $isDebug
                ? [
                    'detail' => $fieldName,
                    'message' => $message,
                ]
                : [],
        ];

        return $this->apiResponse()
            ->setCode(409)
            ->setMessage($response['message'])
            ->errors($response['errors'])
            ->send();
    }


    protected function parseDuplicateKey(string $message): string
    {
        preg_match("/for key '(.+?)'/", $message, $matches);
        if (isset($matches[1])) {
            // Misal 'pegawais_nip_unique' => ambil bagian 'nip'
            $key = $matches[1];
            if (preg_match('/_(\w+)_unique$/', $key, $m)) {
                return $m[1];
            }
            return $key;
        }
        return 'unknown';
    }

    protected function handleMissingColumn(string $message)
    {
        $isDebug = config('app.debug');
        preg_match("/Unknown column '(.+?)'/", $message, $matchesCol);
        preg_match("/insert into `(.+?)`/", $message, $matchesTable);

        $missingColumn = $matchesCol[1] ?? 'unknown';
        $tableName = $matchesTable[1] ?? 'unknown';

        $response = [
            'message' => $isDebug
                ? "Kolom database tidak ditemukan: {$missingColumn}"
                : $this->defaultErrorMessage,
            'errors' => $isDebug
                ? [
                    'detail' => "Kolom '{$missingColumn}' belum ditambahkan di tabel '{$tableName}'.",
                    'message' => $message,
                ]
                : [],
        ];

        return $this->apiResponse()
            ->setCode(500)
            ->setMessage($response['message'])
            ->errors($response['errors'])
            ->send();
    }


    protected function handleNotNullableColumn(string $message)
    {
        $isDebug = config('app.debug');
        preg_match("/Column '(.+?)' cannot be null/", $message, $matches);
        $column = $matches[1] ?? 'unknown';

        $response = [
            'message' => "Kolom '{$column}' tidak boleh kosong.",
            'errors' => $isDebug
                ? [
                    'detail' => "Kolom '{$column}' bersifat wajib (NOT NULL).",
                    'message' => $message,
                ]
                : [],
        ];

        return $this->apiResponse()
            ->setCode(422)
            ->setMessage($response['message'])
            ->errors($response['errors'])
            ->send();
    }


    protected function handleTableNotFound(string $message)
    {
        // Cek environment
        $isDebug = config('app.debug');

        // Ekstrak nama tabel dari pesan error (jika ada)
        preg_match("/Table '(.+?)'/", $message, $matches);
        $tableName = $matches[1] ?? 'unknown';

        $response = [
            'message' => $isDebug
                ? "Tabel database tidak ditemukan: {$tableName}"
                : "Terjadi kesalahan pada server.",
            'errors' => $isDebug
                ? [
                    'detail' => "Tabel '{$tableName}' belum dibuat atau tidak tersedia di database.",
                    'message' => $message,
                ]
                : [],
        ];

        return $this->apiResponse()
            ->setCode(500)
            ->setMessage($response['message'])
            ->errors($response['errors'])
            ->send();
    }

    protected function handleMissingDefaultValue(string $message)
    {
        $isDebug = config('app.debug');

        // Ambil nama kolom yang tidak punya default value
        preg_match("/Field '(.+?)' doesn't have a default value/", $message, $matches);
        $field = $matches[1] ?? 'unknown';

        $response = [
            'message' => "Kolom '{$field}' wajib diisi.",
            'errors' => $isDebug
                ? [
                    'detail' => "Kolom '{$field}' tidak boleh kosong dan tidak memiliki nilai default di database.",
                    'message' => $message,
                ]
                : [],
        ];

        return $this->apiResponse()
            ->setCode(422)
            ->setMessage($response['message'])
            ->errors($response['errors'])
            ->send();
    }

    protected function handleInvalidDateFormat(string $message)
    {
        $isDebug = config('app.debug');

        // Ambil nama kolom dan nilai tanggal dari pesan error
        preg_match("/Incorrect date value: '(.+?)' for column `.+?`\.`.+?`\.`(.+?)`/", $message, $matches);
        $invalidValue = $matches[1] ?? 'unknown';
        $column = $matches[2] ?? 'unknown';

        $response = [
            'message' => "Format tanggal tidak valid untuk kolom '{$column}'.",
            'errors' => $isDebug
                ? [
                    'detail' => "Nilai '{$invalidValue}' tidak sesuai format 'YYYY-MM-DD'.",
                    'message' => $message,
                ]
                : [],
        ];

        return $this->apiResponse()
            ->setCode(422)
            ->setMessage($response['message'])
            ->errors($response['errors'])
            ->send();
    }
}
