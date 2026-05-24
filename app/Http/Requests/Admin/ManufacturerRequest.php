<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManufacturerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $manufacturer = $this->route('manufacturer');
        $manufacturerId = $manufacturer?->id ?? $manufacturer;

        return [
            'entity_id' => [
                'required',
                'integer',
                'exists:entities,id',
                Rule::unique('manufacturers', 'entity_id')->ignore($manufacturerId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'entity_id.required' => 'La entidad es obligatoria.',
            'entity_id.unique' => 'Esa entidad ya está registrada como maquilador.',
        ];
    }
}
