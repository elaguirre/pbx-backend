<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supplier = $this->route('supplier');
        $supplierId = $supplier?->id ?? $supplier;

        return [
            'entity_id' => [
                'required',
                'integer',
                'exists:entities,id',
                Rule::unique('suppliers', 'entity_id')->ignore($supplierId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'entity_id.required' => 'La entidad es obligatoria.',
            'entity_id.unique' => 'Esa entidad ya está registrada como proveedor.',
        ];
    }
}
