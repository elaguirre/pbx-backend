<?php

namespace App\Http\Requests\Admin;

use App\Enums\ShipmentOrderPieceStatus;
use App\Models\OrderPiece;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ShipmentOrderPieceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $shipmentOrderPiece = $this->route('shipment_order_piece');
        $shipmentOrderPieceId = is_object($shipmentOrderPiece) ? $shipmentOrderPiece->getKey() : $shipmentOrderPiece;

        return [
            'shipment_id' => ['required', 'integer', 'exists:shipments,id'],
            'order_piece_id' => [
                'required',
                'integer',
                'exists:order_pieces,id',
                Rule::unique('shipment_order_pieces', 'order_piece_id')
                    ->where('shipment_id', $this->input('shipment_id'))
                    ->ignore($shipmentOrderPieceId),
            ],
            'quantity' => ['required', 'numeric', 'min:0.0001'],
            'status' => ['sometimes', 'required', Rule::enum(ShipmentOrderPieceStatus::class)],
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

            $shipmentOrderPiece = $this->route('shipment_order_piece');
            $excludeId = is_object($shipmentOrderPiece) ? $shipmentOrderPiece->getKey() : $shipmentOrderPiece;
            $remaining = $orderPiece->remainingShippableQuantity($excludeId ? (int) $excludeId : null);

            if ((float) $quantity > $remaining + 0.0001) {
                $validator->errors()->add(
                    'quantity',
                    'La cantidad no puede superar la disponible para embarque ('.$remaining.').',
                );
            }

            if (! OrderPiece::isShippableForShipment((int) $orderPieceId)) {
                $validator->errors()->add(
                    'order_piece_id',
                    'Solo se pueden embarcar piezas con manufactura completada liberada para embarque.',
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'shipment_id.required' => 'El embarque es obligatorio.',
            'order_piece_id.required' => 'La pieza de pedido es obligatoria.',
            'order_piece_id.unique' => 'Esa pieza ya está en este embarque.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.min' => 'La cantidad debe ser mayor a cero.',
            'status.required' => 'El estado es obligatorio.',
            'status.enum' => 'El estado seleccionado no es válido.',
        ];
    }
}
