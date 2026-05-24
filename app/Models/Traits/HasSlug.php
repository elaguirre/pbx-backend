<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LogicException;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::saving(function (Model $model) {
            if ($model->shouldRegenerateSlug()) {
                $model->setAttribute($model->getSlugColumn(), $model->generateSlug());
            }
        });
    }

    protected function initializeHasSlug(): void
    {
        $this->assertHasSlugConfiguration();
    }

    public function generateSlug(): string
    {
        $parts = [];

        foreach ($this->getSlugFields() as $field) {
            $value = $this->getAttribute($field);

            if ($value === null || $value === '') {
                continue;
            }

            $part = $this->formatSlugPart((string) $value);

            if ($part !== '') {
                $parts[] = $part;
            }
        }

        return implode('-', $parts);
    }

    protected function shouldRegenerateSlug(): bool
    {
        if (! $this->exists) {
            return true;
        }

        return $this->isDirty($this->getSlugFields());
    }

    protected function formatSlugPart(string $value): string
    {
        $value = trim($value);

        if ($value === '') {
            return '';
        }

        if (preg_match('/^[a-zA-Z0-9_-]+$/', $value)) {
            return $value;
        }

        return Str::slug($value, '-', 'es');
    }

    protected function getSlugColumn(): string
    {
        return 'slug';
    }

    /**
     * @return list<string>
     */
    protected function getSlugFields(): array
    {
        if (! property_exists($this, 'slug_fields') || ! is_array($this->slug_fields)) {
            return [];
        }

        return array_values($this->slug_fields);
    }

    protected function assertHasSlugConfiguration(): void
    {
        $model = static::class;

        if (! in_array($this->getSlugColumn(), $this->getFillable(), true)) {
            throw new LogicException("{$model} must include '{$this->getSlugColumn()}' in \$fillable to use HasSlug.");
        }

        $fields = $this->getSlugFields();

        if ($fields === []) {
            throw new LogicException("{$model} must define a non-empty \$slug_fields array.");
        }

        foreach ($fields as $field) {
            if (! is_string($field) || $field === '' || $field === $this->getSlugColumn()) {
                throw new LogicException("{$model} has an invalid entry in \$slug_fields.");
            }

            if (! in_array($field, $this->getFillable(), true)) {
                throw new LogicException("{$model} \$slug_fields entry '{$field}' must exist in \$fillable.");
            }
        }
    }
}
