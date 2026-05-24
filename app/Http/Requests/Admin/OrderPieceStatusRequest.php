<?php

namespace App\Http\Requests\Admin;

use App\Enums\OrderPieceStatusRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderPieceStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $status = $this->route('order_piece_status');
        $statusId = is_object($status) ? $status?->id : $status;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('order_piece_statuses', 'name')->ignore($statusId),
            ],
            'details' => ['nullable', 'string'],
            'role' => ['nullable', Rule::enum(OrderPieceStatusRole::class)],
            'order' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.unique' => 'Ya existe un estado con ese nombre.',
            'role.enum' => 'El rol seleccionado no es válido.',
            'order.required' => 'El orden es obligatorio.',
            'order.min' => 'El orden no puede ser negativo.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('role') && $this->input('role') === '') {
            $this->merge(['role' => null]);
        }
    }
}
