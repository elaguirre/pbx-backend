<?php

namespace App\Models\Traits;

use App\Models\User;

trait HasAuthor
{
    public function getAuthorColumn(): string
    {
        if (!property_exists(self::class, 'author_column')) {
            return 'created_by';
        }

        return $this->author_column;
    }

    public static function bootHasAuthor()
    {
        static::creating(function ($record) {
            $record->{$record->getAuthorColumn()} = auth()->id() ?? 0;
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, $this->getAuthorColumn());
    }
}
