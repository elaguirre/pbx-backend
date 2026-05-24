<?php

namespace App\Http\Requests\Admin;

use App\Models\CarrierUnit;
use App\Models\Driver;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ShipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'carrier_id' => ['required', 'integer', 'exists:carriers,id'],
            'carrier_unit_id' => ['required', 'integer', 'exists:carrier_units,id'],
            'driver_id' => ['nullable', 'integer', 'exists:drivers,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $carrierId = $this->input('carrier_id');
            $carrierUnitId = $this->input('carrier_unit_id');

            if (! $carrierId || ! $carrierUnitId) {
                return;
            }

            $unitBelongs = CarrierUnit::query()
                ->whereKey($carrierUnitId)
                ->where('carrier_id', $carrierId)
                ->exists();

            if (! $unitBelongs) {
                $validator->errors()->add(
                    'carrier_unit_id',
                    'La unidad de transporte no pertenece al transportista seleccionado.',
                );
            }

            $driverId = $this->input('driver_id');

            if (! $driverId) {
                return;
            }

            $driverBelongs = Driver::query()
                ->whereKey($driverId)
                ->where('carrier_id', $carrierId)
                ->exists();

            if (! $driverBelongs) {
                $validator->errors()->add(
                    'driver_id',
                    'El conductor no pertenece al transportista seleccionado.',
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'carrier_id.required' => 'El transportista es obligatorio.',
            'carrier_unit_id.required' => 'La unidad de transporte es obligatoria.',
        ];
    }
}
