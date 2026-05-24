<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class OrderConceptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_modification_reason' => ['nullable', 'string'],
            'details' => ['nullable', 'string'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $productId = $this->input('product_id');

            if (! $productId) {
                return;
            }

            $product = Product::query()->find($productId);

            if (! $product) {
                return;
            }

            $originalPrice = (float) $product->price;
            $submittedPrice = $this->input('price');

            if ($submittedPrice === null || $submittedPrice === '') {
                return;
            }

            if (abs((float) $submittedPrice - $originalPrice) < 0.0001) {
                return;
            }

            if (! $this->filled('price_modification_reason')) {
                $validator->errors()->add(
                    'price_modification_reason',
                    'Indique el motivo al modificar el precio.',
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'El pedido es obligatorio.',
            'product_id.required' => 'El producto es obligatorio.',
            'quantity.required' => 'La cantidad es obligatoria.',
        ];
    }
}
