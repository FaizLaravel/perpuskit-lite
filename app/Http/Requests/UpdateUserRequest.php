<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'nik' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'email_verified_at' => 'nullable|date',
            'no_hp' => 'nullable|string|max:13',
            'profile_user' => 'nullable|image|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'level' => 'required|in:admin,anggota,petugas',
        ];
    }
}
