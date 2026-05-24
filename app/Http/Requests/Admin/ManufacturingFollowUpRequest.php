<?php

namespace App\Http\Requests\Admin;

use App\Enums\ManufacturingFollowUpResult;
use App\Models\ManufacturingFollowUp;
use App\Models\ManufacturerOrderPiece;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ManufacturingFollowUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $followUp = $this->route('mfg_follow_up');
        $isUpdate = $followUp !== null;
        $result = ManufacturingFollowUpResult::tryFrom($this->input('result', ''));

        $rules = [
            'result' => ['required', Rule::enum(ManufacturingFollowUpResult::class)],
            'details' => [
                Rule::requiredIf($result?->requiresDetails() ?? false),
                'nullable',
                'string',
                'max:5000',
            ],
            'quantity' => [
                Rule::requiredIf($result?->requiresQuantity() ?? false),
                'nullable',
                'numeric',
                'gt:0',
            ],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
        ];

        if (! $isUpdate) {
            $rules['manufacturer_order_piece_id'] = ['required', 'integer', 'exists:manufacturer_order_pieces,id'];
        }

        return $rules;
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $result = ManufacturingFollowUpResult::from($this->input('result'));

            if ($result !== ManufacturingFollowUpResult::CompletedPieces) {
                return;
            }

            $assignmentId = $this->resolveAssignmentId();
            $assignment = ManufacturerOrderPiece::query()->find($assignmentId);

            if (! $assignment) {
                return;
            }

            $followUp = $this->route('mfg_follow_up');
            $excludeId = $followUp?->getKey();

            $completedTotal = ManufacturingFollowUp::query()
                ->where('manufacturer_order_piece_id', $assignmentId)
                ->where('result', ManufacturingFollowUpResult::CompletedPieces)
                ->when($excludeId, fn ($query) => $query->whereKeyNot($excludeId))
                ->sum('quantity');

            $newTotal = (float) $completedTotal + (float) $this->input('quantity');

            if ($newTotal > (float) $assignment->quantity) {
                $validator->errors()->add(
                    'quantity',
                    'Las piezas completadas no pueden superar la cantidad asignada a la orden.',
                );
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $result = ManufacturingFollowUpResult::tryFrom($this->input('result', ''));

        if (! $result) {
            return;
        }

        if (! $result->requiresQuantity()) {
            $this->merge(['quantity' => null]);
        }

        $details = $this->input('details');

        if ($details === '' || $details === null) {
            $this->merge(['details' => null]);
        }

        if (auth()->id()) {
            $this->merge(['user_id' => auth()->id()]);
        }
    }

    protected function resolveAssignmentId(): ?int
    {
        $followUp = $this->route('mfg_follow_up');

        if ($followUp) {
            return $followUp->manufacturer_order_piece_id;
        }

        return $this->integer('manufacturer_order_piece_id') ?: null;
    }

    public function messages(): array
    {
        return [
            'manufacturer_order_piece_id.required' => 'La asignación de pieza es obligatoria.',
            'result.required' => 'El resultado es obligatorio.',
            'details.required' => 'Los detalles son obligatorios para este tipo de seguimiento.',
            'quantity.required' => 'La cantidad es obligatoria para piezas completadas o canceladas.',
            'quantity.gt' => 'La cantidad debe ser mayor a cero.',
        ];
    }
}
