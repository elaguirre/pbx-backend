<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!auth()->user()->checkPassword($value)) {
                        $fail('La contraseña actual no coincide.');
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
                'different:old_password',
            ]
        ];
    }
}
