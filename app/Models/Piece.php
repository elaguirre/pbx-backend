<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Piece extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'name', 'volume', 'weight', 'created_at'];
    protected $allowed_includes = ['products', 'pieceMaterials', 'pieceMaterials.material'];

    protected $fillable = [
        'name',
        'volume',
        'weight',
    ];

    protected function casts(): array
    {
        return [
            'volume' => 'decimal:4',
            'weight' => 'decimal:4',
        ];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_pieces')->withTimestamps();
    }

    public function productPieces(): HasMany
    {
        return $this->hasMany(ProductPiece::class);
    }

    public function pieceMaterials(): HasMany
    {
        return $this->hasMany(PieceMaterial::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'piece_materials')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('pieces.id', $text);
            }

            $query->orWhere('pieces.name', 'like', "%{$text}%");
        });
    }

    public function scopeAdvancedSearch($query)
    {
        return $query;
    }
}
