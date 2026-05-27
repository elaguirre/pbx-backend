<?php

namespace App\Http\Requests\Admin;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['sometimes', 'required', 'integer', 'exists:clients,id'],
            'status' => ['sometimes', 'required', Rule::enum(OrderStatus::class)],
            'cancellation_reason' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            if ($this->isCanceledStatus($this->input('status')) && ! $this->filled('cancellation_reason')) {
                $validator->errors()->add(
                    'cancellation_reason',
                    'El motivo de cancelación es obligatorio cuando el pedido está cancelado.',
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'El cliente es obligatorio.',
            'status.required' => 'El estado es obligatorio.',
            'cancellation_reason.max' => 'El motivo de cancelación es demasiado largo.',
        ];
    }

    protected function isCanceledStatus(mixed $status): bool
    {
        if ($status === null) {
            return false;
        }

        if ($status instanceof OrderStatus) {
            return $status === OrderStatus::Canceled;
        }

        if (is_numeric($status)) {
            return (int) $status === OrderStatus::Canceled->value;
        }

        return $status === OrderStatus::Canceled->name;
    }
}
