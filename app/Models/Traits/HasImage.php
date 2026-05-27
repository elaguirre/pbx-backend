<?php

namespace App\Models\Traits;

use App\Enums\ImageType;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HasImage
{
    public static function bootHasImage(): void
    {
        static::deleting(function (Model $model) {
            $model->images()->get()->each->delete();
        });
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function mainImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', ImageType::Main);
    }

    public function storeMainImage(UploadedFile $file): Image
    {
        $path = $file->store($this->imageStorageDirectory(), 'public');
        $mainImage = $this->mainImage()->first();

        if ($mainImage) {
            $mainImage->delete();
        }

        return $this->images()->create([
            'type' => ImageType::Main,
            'path' => $path,
        ]);
    }

    protected function imageStorageDirectory(): string
    {
        $segment = Str::plural(Str::snake(class_basename($this)));

        return "images/{$segment}/{$this->getKey()}";
    }
}
