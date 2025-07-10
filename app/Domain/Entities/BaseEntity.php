<?php

namespace App\Domain\Entities;

abstract class BaseEntity
{
    protected array $onlyFields = [];

    public static function fromDTO(object $dto, ?self $existingEntity = null): static
    {
        $instance = $existingEntity ?? new static();

        // Ambil semua properti termasuk yang bernilai false/null
        $data = property_exists($dto, 'data') ? (array)$dto->data : (array)$dto;

        // Jika DTO punya ID di properti terpisah
        if (property_exists($dto, 'id')) {
            $data['id'] = $dto->id;
        }

        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->{$key} = $value;
                $instance->onlyFields[] = $key;
            }
        }

        return $instance;
    }

    public function setProperty(string $key, $value): void
    {
        if (property_exists($this, $key)) {
            $this->{$key} = $value;
            if (!in_array($key, $this->onlyFields)) {
                $this->onlyFields[] = $key;
            }
        }
    }


    public function toArray(): array
    {
        // Kembalikan hanya field yang diisi user
        return collect(get_object_vars($this))
            ->only($this->onlyFields)
            ->toArray();
    }

    public function toFullArray(): array
    {
        // Untuk keperluan debug atau kebutuhan lain
        return get_object_vars($this);
    }
}
