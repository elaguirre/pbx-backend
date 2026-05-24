<?php

namespace App\Http\Requests\Admin;

use App\Enums\ContactDataType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'entity_id' => ['required', 'integer', 'exists:entities,id'],
            'type' => ['required', Rule::enum(ContactDataType::class)],
            'value' => ['required', 'string', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'entity_id.required' => 'La entidad es obligatoria.',
            'entity_id.exists' => 'La entidad seleccionada no existe.',
            'type.required' => 'El tipo de contacto es obligatorio.',
            'value.required' => 'El valor es obligatorio.',
        ];
    }
}
