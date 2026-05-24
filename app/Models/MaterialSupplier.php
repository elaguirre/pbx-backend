<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MaterialSupplier extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'created_at'];
    protected $allowed_includes = [
        'material',
        'supplier',
        'supplier.entity',
        'latestPrice',
        'prices',
    ];

    protected $fillable = [
        'material_id',
        'supplier_id',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(MaterialSupplierPrice::class);
    }

    public function latestPrice(): HasOne
    {
        return $this->hasOne(MaterialSupplierPrice::class)->latestOfMany();
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('material_suppliers.id', $text);
            }

            $query->orWhereHas('material', function ($query) use ($text) {
                $query->where('materials.name', 'like', "%{$text}%");
            })->orWhereHas('supplier.entity', function ($query) use ($text) {
                $query->where('entities.name', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('material_id')) {
            $query->where('material_suppliers.material_id', request('material_id'));
        }

        if (request()->filled('supplier_id')) {
            $query->where('material_suppliers.supplier_id', request('supplier_id'));
        }

        return $query;
    }
}
