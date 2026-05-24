<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'name', 'uom', 'created_at'];
    protected $allowed_includes = [
        'pieces',
        'pieceMaterials',
        'pieceMaterials.piece',
        'materialSuppliers',
        'materialSuppliers.supplier',
        'materialSuppliers.supplier.entity',
        'materialSuppliers.latestPrice',
        'suppliers',
    ];

    protected $fillable = [
        'name',
        'uom',
    ];

    public function pieces(): BelongsToMany
    {
        return $this->belongsToMany(Piece::class, 'piece_materials')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function pieceMaterials(): HasMany
    {
        return $this->hasMany(PieceMaterial::class);
    }

    public function materialSuppliers(): HasMany
    {
        return $this->hasMany(MaterialSupplier::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'material_suppliers')->withTimestamps();
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('materials.id', $text);
            }

            $query->orWhere('materials.name', 'like', "%{$text}%")
                ->orWhere('materials.uom', 'like', "%{$text}%");
        });
    }

    public function scopeAdvancedSearch($query)
    {
        return $query;
    }
}
