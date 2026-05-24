<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MaterialSupplierPriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $priceRecord = $this->route('material_supplier_price');
        $isUpdate = $priceRecord !== null;

        $rules = [
            'price' => ['required', 'numeric', 'min:0'],
        ];

        if (! $isUpdate) {
            $rules['material_supplier_id'] = ['required', 'integer', 'exists:material_suppliers,id'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'material_supplier_id.required' => 'La asignación material-proveedor es obligatoria.',
            'price.required' => 'El precio es obligatorio.',
            'price.min' => 'El precio no puede ser negativo.',
        ];
    }
}
