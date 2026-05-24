<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderPieceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $orderPiece = $this->route('order_piece');
        $orderPieceId = $orderPiece?->id ?? $orderPiece;

        return [
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'order_concept_id' => [
                'required',
                'integer',
                Rule::exists('order_concepts', 'id')->where('order_id', $this->input('order_id')),
            ],
            'piece_id' => [
                'required',
                'integer',
                'exists:pieces,id',
                Rule::unique('order_pieces', 'piece_id')
                    ->where('order_concept_id', $this->input('order_concept_id'))
                    ->ignore($orderPieceId),
            ],
            'quantity' => ['required', 'numeric', 'min:0'],
            'order_piece_status_id' => ['nullable', 'integer', 'exists:order_piece_statuses,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'El pedido es obligatorio.',
            'order_concept_id.required' => 'El concepto de pedido es obligatorio.',
            'order_concept_id.exists' => 'El concepto no pertenece a este pedido.',
            'piece_id.required' => 'La pieza es obligatoria.',
            'piece_id.unique' => 'Esa pieza ya está registrada en este concepto.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.min' => 'La cantidad no puede ser negativa.',
        ];
    }
}
