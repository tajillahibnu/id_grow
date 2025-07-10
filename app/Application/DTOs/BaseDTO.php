<?php

namespace App\Application\DTOs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class BaseDTO
{
    protected Model $model;
    public array $extra = []; // <- Tambahkan ini untuk menampung metadata

    public function __construct(
        public ?string $id,
        public array $data
    ) {}

    protected function extractData(Request $request): array
    {
        $fillable = $this->model->getFillable();
        $input = $request->input();
        $data = [];
        $extra = [];

        // foreach ($fillable as $field) {
        // if (array_key_exists($field, $input)) {
        //     $data[$field] = $input[$field];
        //     // Trim dulu, lalu strip_tags untuk menghapus tag HTML/JS
        //     // $value = is_string($input[$field]) ? strip_tags(trim($input[$field])) : $input[$field];
        //     // $data[$field] = $value;
        // }
        // }

        foreach ($input as $key => $value) {
            if (in_array($key, $fillable)) {
                $data[$key] = $value;
            } else {
                $extra[$key] = $value;
            }
        }
        $this->extra = $extra; // simpan metadata
        // dd('extractData - extra:', $this->extra, 'data:', $data);

        return $data;
    }

    public static function fromRequest(Request $request, ?string $id = null): static
    {
        $instance = new static($id, []);
        $data = $instance->extractData($request); // akan mengisi $instance->extra
        $instance->data = $data; // set data juga ke instance yang sama
        return $instance; // kembalikan instance yang sudah lengkap ini
    }


    public static function forCreate(Request $request): static
    {
        return static::fromRequest($request, null);
    }

    public static function forUpdate(Request $request, string $id): static
    {
        return static::fromRequest($request, $id);
    }

    public function isUpdate(): bool
    {
        return $this->id !== null;
    }
}
