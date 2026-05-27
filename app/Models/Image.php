<?php

namespace App\Models;

use App\Enums\ImageType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'type',
        'path',
    ];

    protected $appends = [
        'url',
    ];

    protected $hidden = [
        'imageable_type',
        'imageable_id',
    ];

    protected function casts(): array
    {
        return [
            'type' => ImageType::class,
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Image $image) {
            if ($image->path !== '') {
                Storage::disk('public')->delete($image->path);
            }
        });
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string
    {
        $url = tenant_asset($this->path);

        if (! tenancy()->initialized) {
            return $url;
        }

        $separator = str_contains($url, '?') ? '&' : '?';

        return $url.$separator.'tenant='.urlencode(tenant('id'));
    }
}
