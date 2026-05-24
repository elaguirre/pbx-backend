<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductPieceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productPiece = $this->route('product_piece');
        $productPieceId = $productPiece?->id ?? $productPiece;

        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'piece_id' => [
                'required',
                'integer',
                'exists:pieces,id',
                Rule::unique('product_pieces', 'piece_id')
                    ->where('product_id', $this->input('product_id'))
                    ->ignore($productPieceId),
            ],
            'quantity' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'El producto es obligatorio.',
            'piece_id.required' => 'La pieza es obligatoria.',
            'piece_id.unique' => 'Esa pieza ya está asignada a este producto.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.min' => 'La cantidad no puede ser negativa.',
        ];
    }
}
