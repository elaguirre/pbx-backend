<?php

namespace App\Http\Requests\Admin;

use App\Rules\ReCaptchaV3;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'email' => 'string|email|valid_email|required',
            'password' => 'string|required',
        ];

        if (\App::environment('production') && config('services.recaptcha_v3.secret')) {
            $rules['recaptcha'] = ['required', new ReCaptchaV3(min_score: '0.7')];
        }

        return $rules;
    }
}
