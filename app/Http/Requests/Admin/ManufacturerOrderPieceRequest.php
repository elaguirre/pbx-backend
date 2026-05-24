<?php

namespace App\Http\Requests\Admin;

use App\Models\OrderPiece;
use App\Services\OrderPieceAssignmentCalculator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ManufacturerOrderPieceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $manufacturerOrderPiece = $this->route('manufacturer_order_piece');
        $manufacturerOrderPieceId = $manufacturerOrderPiece?->id ?? $manufacturerOrderPiece;

        return [
            'production_order_id' => ['required', 'integer', 'exists:production_orders,id'],
            'order_piece_id' => [
                'required',
                'integer',
                'exists:order_pieces,id',
                Rule::unique('manufacturer_order_pieces', 'order_piece_id')
                    ->where('production_order_id', $this->input('production_order_id'))
                    ->ignore($manufacturerOrderPieceId),
            ],
            'quantity' => ['required', 'numeric', 'min:0.0001'],
            'available_status_id' => ['required', 'integer', 'exists:order_piece_statuses,id'],
            'status_of_completed_pieces' => [
                'required',
                'integer',
                'exists:order_piece_statuses,id',
                'different:available_status_id',
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $orderPieceId = $this->input('order_piece_id');
            $quantity = $this->input('quantity');

            if (! $orderPieceId || $quantity === null || $quantity === '') {
                return;
            }

            $orderPiece = OrderPiece::query()->find($orderPieceId);

            if (! $orderPiece) {
                return;
            }

            $routeAssignment = $this->route('manufacturer_order_piece');
            $excludeId = is_object($routeAssignment) ? $routeAssignment->getKey() : $routeAssignment;

            $calculator = app(OrderPieceAssignmentCalculator::class);
            $assigned = $calculator->assignedQuantitiesByOrderPieceId(
                [(int) $orderPieceId],
                $excludeId ? (int) $excludeId : null,
                (int) $this->input('production_order_id'),
            );
            $already = (float) ($assigned[(int) $orderPieceId] ?? 0);
            $remaining = (float) $orderPiece->quantity - $already;

            if ((float) $quantity > $remaining + 0.0001) {
                $validator->errors()->add(
                    'quantity',
                    'La cantidad no puede superar lo disponible ('.$remaining.' de '.$orderPiece->quantity.').',
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'production_order_id.required' => 'La orden de producción es obligatoria.',
            'order_piece_id.required' => 'La pieza de pedido es obligatoria.',
            'order_piece_id.unique' => 'Esa pieza de pedido ya está en esta orden de producción.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.min' => 'La cantidad debe ser mayor a cero.',
            'available_status_id.required' => 'El estado requerido de la pieza es obligatorio.',
            'status_of_completed_pieces.required' => 'El estado de la pieza al completar es obligatorio.',
            'status_of_completed_pieces.different' => 'El estado al completar debe ser distinto al estado requerido.',
        ];
    }
}
