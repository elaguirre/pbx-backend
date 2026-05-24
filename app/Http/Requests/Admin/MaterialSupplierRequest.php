<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaterialSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $materialSupplier = $this->route('material_supplier');
        $materialSupplierId = $materialSupplier?->id ?? $materialSupplier;

        return [
            'material_id' => ['required', 'integer', 'exists:materials,id'],
            'supplier_id' => [
                'required',
                'integer',
                'exists:suppliers,id',
                Rule::unique('material_suppliers', 'supplier_id')
                    ->where('material_id', $this->input('material_id'))
                    ->ignore($materialSupplierId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'material_id.required' => 'El material es obligatorio.',
            'supplier_id.required' => 'El proveedor es obligatorio.',
            'supplier_id.unique' => 'Ese proveedor ya está asignado a este material.',
        ];
    }
}
