<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|valid_email|required|unique:users,email,'.($this->route('admin')?->id ?? 0),
            'password' => [
                'nullable',
                'string',
                'required_without:id',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'profile' => 'numeric|nullable',
            'role_id' => 'numeric|nullable',
            'branch_id' => 'numeric|nullable',
            'active' => 'boolean|required_with:id',

            'has_2fa_enabled' => 'boolean',
            'phone' => 'numeric|nullable|digits_between:9,10|required_if:has_2fa_enabled,true',
        ];
    }
}
