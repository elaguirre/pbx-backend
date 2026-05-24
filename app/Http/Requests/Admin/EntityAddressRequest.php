<?php

namespace App\Http\Requests\Admin;

use App\Enums\EntityAddressType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntityAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'entity_id' => ['required', 'integer', 'exists:entities,id'],
            'type' => ['required', Rule::enum(EntityAddressType::class)],
            'street' => ['required', 'string', 'max:255'],
            'external_number' => ['required', 'string', 'max:40'],
            'internal_number' => ['nullable', 'string', 'max:40'],
            'suburb' => ['required', 'string', 'max:120'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'entity_id.required' => 'La entidad es obligatoria.',
            'type.required' => 'El tipo de dirección es obligatorio.',
            'street.required' => 'La calle es obligatoria.',
            'external_number.required' => 'El número exterior es obligatorio.',
            'suburb.required' => 'La colonia es obligatoria.',
            'city_id.required' => 'La ciudad es obligatoria.',
        ];
    }
}
