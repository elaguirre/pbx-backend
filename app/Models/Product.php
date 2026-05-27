<?php

namespace App\Models;

use App\Models\Traits\HasImage;
use App\Models\Traits\HasQueryBuilder;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    use HasImage;
    use HasQueryBuilder;
    use HasSlug;

    /** @var list<string> */
    protected array $slug_fields = ['name', 'sku'];

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'sku', 'slug', 'name', 'price', 'created_at'];
    protected $allowed_includes = ['images', 'productPieces', 'productPieces.piece', 'pieces'];

    protected $fillable = [
        'sku',
        'slug',
        'name',
        'price',
        'details',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function pieces(): BelongsToMany
    {
        return $this->belongsToMany(Piece::class, 'product_pieces')->withTimestamps();
    }

    public function productPieces(): HasMany
    {
        return $this->hasMany(ProductPiece::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('products.id', $text);
            }

            $query
                ->orWhere('products.sku', 'like', "%{$text}%")
                ->orWhere('products.slug', 'like', "%{$text}%")
                ->orWhere('products.name', 'like', "%{$text}%")
                ->orWhere('products.details', 'like', "%{$text}%");
        });
    }

    public function scopeAdvancedSearch($query)
    {
        return $query;
    }
}
