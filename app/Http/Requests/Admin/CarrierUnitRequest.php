<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CarrierUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'carrier_id' => ['required', 'integer', 'exists:carriers,id'],
            'description' => ['required', 'string'],
            'load_volume_capacity' => ['required', 'numeric', 'min:0.0001'],
            'load_weight_capacity' => ['required', 'numeric', 'min:0.0001'],
            'price_by_volume' => ['nullable', 'numeric', 'min:0'],
            'price_by_weight' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'carrier_id.required' => 'El transportista es obligatorio.',
            'description.required' => 'La descripción es obligatoria.',
            'load_volume_capacity.required' => 'La capacidad volumétrica es obligatoria.',
            'load_volume_capacity.min' => 'La capacidad volumétrica debe ser mayor a cero.',
            'load_weight_capacity.required' => 'La capacidad de peso es obligatoria.',
            'load_weight_capacity.min' => 'La capacidad de peso debe ser mayor a cero.',
            'price_by_volume.min' => 'El precio por volumen no puede ser negativo.',
            'price_by_weight.min' => 'El precio por peso no puede ser negativo.',
        ];
    }
}
