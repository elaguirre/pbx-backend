<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $driver = $this->route('driver');
        $driverId = is_object($driver) ? $driver->getKey() : $driver;

        return [
            'carrier_id' => ['required', 'integer', 'exists:carriers,id'],
            'entity_id' => [
                'required',
                'integer',
                'exists:entities,id',
                Rule::unique('drivers', 'entity_id')
                    ->where('carrier_id', $this->input('carrier_id'))
                    ->ignore($driverId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'carrier_id.required' => 'El transportista es obligatorio.',
            'entity_id.required' => 'La entidad es obligatoria.',
            'entity_id.unique' => 'Esa entidad ya está registrada como conductor de este transportista.',
        ];
    }
}
