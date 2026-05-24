<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PieceMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pieceMaterial = $this->route('piece_material');
        $pieceMaterialId = $pieceMaterial?->id ?? $pieceMaterial;

        return [
            'piece_id' => ['required', 'integer', 'exists:pieces,id'],
            'material_id' => [
                'required',
                'integer',
                'exists:materials,id',
                Rule::unique('piece_materials', 'material_id')
                    ->where('piece_id', $this->input('piece_id'))
                    ->ignore($pieceMaterialId),
            ],
            'quantity' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'piece_id.required' => 'La pieza es obligatoria.',
            'material_id.required' => 'El material es obligatorio.',
            'material_id.unique' => 'Ese material ya está asignado a esta pieza.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.min' => 'La cantidad no puede ser negativa.',
        ];
    }
}
