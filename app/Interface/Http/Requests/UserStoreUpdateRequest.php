<?php

namespace App\Interface\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        // Mendapatkan id dari route jika ada (URL seperti /users/{id})
        $id = $this->route('id');

        $rules = [
            'name'             => ['required', 'string', 'max:150'],
            'romawi'           => ['nullable', 'string'],
            'lokasi_id'        => ['required', 'exists:lokasis,id'],  // Lokasi ID harus ada dalam tabel `lokasis`
            'primary_role_id'  => ['required', 'exists:app_roles,id'],  // Role ID harus ada dalam tabel `roles`
        ];

        // Validasi khusus untuk update jika ID diberikan di URL
        if ($id) {
            // Misalnya validasi untuk email dan password khusus update
            $rules['email'] = ['nullable', 'email', Rule::unique('users')->ignore($id)];
            $rules['password'] = ['nullable', 'min:8'];
        } else {
            // Jika tidak ada ID, misalnya untuk create, email dan password wajib
            $rules['email'] = ['required', 'email', 'unique:users,email'];
            $rules['password'] = ['required', 'min:8'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Nama wajib diisi.',
            'name.max'                 => 'Nama maksimal 150 karakter.',
            'lokasi_id.required'      => 'Lokasi ID wajib diisi.',
            'lokasi_id.exists'        => 'Lokasi yang dipilih tidak valid.',
            'primary_role_id.required' => 'Primary role (role user) ID wajib diisi.',
            'primary_role_id.exists'  => 'Role yang dipilih tidak valid.',
            'email.required'          => 'Email wajib diisi.',
            'email.email'             => 'Email tidak valid.',
            'email.unique'            => 'Email sudah digunakan.',
            'password.required'       => 'Password wajib diisi.',
            'password.min'            => 'Password minimal 8 karakter.',
        ];
    }

    public function authorize(): bool
    {
        return true;  // Anda bisa menambahkan otorisasi logika di sini jika diperlukan
    }
}
