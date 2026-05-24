<?php

namespace App\Models;

use App\Enums\ContactDataType;
use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactData extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $table = 'contact_data';

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'type', 'value', 'created_at'];
    protected $allowed_includes = ['entity'];

    protected $fillable = [
        'entity_id',
        'type',
        'value',
    ];

    protected function casts(): array
    {
        return [
            'type' => ContactDataType::class,
        ];
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('contact_data.id', $text);
            }

            $query->orWhere('contact_data.value', 'like', "%{$text}%");
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('entity_id')) {
            $query->where('contact_data.entity_id', request('entity_id'));
        }

        return $query;
    }
}
