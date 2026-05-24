<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShipmentDriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $shipmentDriver = $this->route('shipment_driver');
        $shipmentDriverId = is_object($shipmentDriver) ? $shipmentDriver->getKey() : $shipmentDriver;

        return [
            'shipment_id' => ['required', 'integer', 'exists:shipments,id'],
            'driver_id' => [
                'required',
                'integer',
                'exists:drivers,id',
                Rule::unique('shipment_drivers', 'driver_id')
                    ->where('shipment_id', $this->input('shipment_id'))
                    ->ignore($shipmentDriverId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'shipment_id.required' => 'El embarque es obligatorio.',
            'driver_id.required' => 'El conductor es obligatorio.',
            'driver_id.unique' => 'Ese conductor ya está asignado a este embarque.',
        ];
    }
}
