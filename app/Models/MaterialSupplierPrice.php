<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialSupplierPrice extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'price', 'created_at'];
    protected $allowed_includes = ['materialSupplier', 'materialSupplier.material', 'materialSupplier.supplier'];

    protected $fillable = [
        'material_supplier_id',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function materialSupplier(): BelongsTo
    {
        return $this->belongsTo(MaterialSupplier::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('material_supplier_prices.id', $text);
            }
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('material_supplier_id')) {
            $query->where('material_supplier_prices.material_supplier_id', request('material_supplier_id'));
        }

        return $query;
    }
}
