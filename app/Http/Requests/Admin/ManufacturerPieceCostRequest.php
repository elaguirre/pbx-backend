<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManufacturerPieceCostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $manufacturerPieceCost = $this->route('manufacturer_piece_cost');
        $manufacturerPieceCostId = $manufacturerPieceCost?->id ?? $manufacturerPieceCost;

        return [
            'manufacturer_id' => ['required', 'integer', 'exists:manufacturers,id'],
            'piece_id' => [
                'required',
                'integer',
                'exists:pieces,id',
                Rule::unique('manufacturer_pieces_cost', 'piece_id')
                    ->where('manufacturer_id', $this->input('manufacturer_id'))
                    ->ignore($manufacturerPieceCostId),
            ],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'manufacturer_id.required' => 'El maquilador es obligatorio.',
            'piece_id.required' => 'La pieza es obligatoria.',
            'piece_id.unique' => 'Esa pieza ya tiene costo registrado para este maquilador.',
            'price.required' => 'El precio es obligatorio.',
            'price.min' => 'El precio no puede ser negativo.',
        ];
    }
}
