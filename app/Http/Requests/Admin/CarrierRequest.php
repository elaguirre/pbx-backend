<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarrierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $carrier = $this->route('carrier');
        $carrierId = is_object($carrier) ? $carrier->getKey() : $carrier;

        return [
            'entity_id' => [
                'required',
                'integer',
                'exists:entities,id',
                Rule::unique('carriers', 'entity_id')->ignore($carrierId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'entity_id.required' => 'La entidad es obligatoria.',
            'entity_id.unique' => 'Esa entidad ya está registrada como transportista.',
        ];
    }
}
