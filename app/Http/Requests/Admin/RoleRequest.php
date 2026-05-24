<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|required',
            'title' => 'string|required',
            'priority' => 'numeric|required',
        ];
    }
}
