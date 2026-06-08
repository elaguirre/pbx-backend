<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductionOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'manufacturer_id' => ['required', 'integer', 'exists:manufacturers,id'],
            'production_batch_id' => ['nullable', 'integer', 'exists:production_batches,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'manufacturer_id.required' => 'El maquilador es obligatorio.',
            'production_batch_id.exists' => 'El lote de producción no existe.',
        ];
    }
}
