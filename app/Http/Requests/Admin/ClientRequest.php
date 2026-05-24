<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $client = $this->route('client');
        $clientId = $client?->id ?? $client;

        return [
            'entity_id' => [
                'required',
                'integer',
                'exists:entities,id',
                Rule::unique('clients', 'entity_id')->ignore($clientId),
            ],
            'term_in_days' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'entity_id.required' => 'La entidad es obligatoria.',
            'entity_id.unique' => 'Esa entidad ya está registrada como cliente.',
            'term_in_days.required' => 'El plazo en días es obligatorio.',
        ];
    }
}
