<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShipmentRouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $shipmentRoute = $this->route('shipment_route');
        $shipmentRouteId = is_object($shipmentRoute) ? $shipmentRoute->getKey() : $shipmentRoute;

        return [
            'shipment_id' => ['required', 'integer', 'exists:shipments,id'],
            'entity_address_id' => [
                'required',
                'integer',
                'exists:entity_addresses,id',
                Rule::unique('shipment_routes', 'entity_address_id')
                    ->where('shipment_id', $this->input('shipment_id'))
                    ->ignore($shipmentRouteId),
            ],
            'order' => ['sometimes', 'required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'shipment_id.required' => 'El embarque es obligatorio.',
            'entity_address_id.required' => 'La dirección es obligatoria.',
            'entity_address_id.unique' => 'Esa dirección ya está en la ruta del embarque.',
            'order.required' => 'El orden es obligatorio.',
        ];
    }
}
