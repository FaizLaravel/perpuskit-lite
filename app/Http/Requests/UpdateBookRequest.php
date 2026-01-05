<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'tanggal_terbit' => 'required|date_format:Y-m-d',
            'ISBN' => [
                'required',
                'string',
                'max:20',
            ],
            'jumlah_halaman' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
        ];
    }
}
