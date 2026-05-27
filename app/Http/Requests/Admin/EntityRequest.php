<?php

namespace App\Http\Requests\Admin;

use App\Enums\EntityType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => ['nullable', 'image', 'max:5120'],
            'name' => ['required', 'string', 'max:150'],
            'rfc' => ['nullable', 'string', 'max:50'],
            'type' => ['required', Rule::enum(EntityType::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'type.required' => 'El tipo de entidad es obligatorio.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.max' => 'La imagen no puede superar 5 MB.',
        ];
    }
}
