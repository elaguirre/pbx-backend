<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionOrder extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'created_at'];
    protected $allowed_includes = [
        'manufacturer',
        'manufacturer.entity',
        'productionBatch',
        'manufacturerOrderPieces',
        'manufacturerOrderPieces.orderPiece',
        'manufacturerOrderPieces.orderPiece.piece',
    ];

    protected $fillable = [
        'manufacturer_id',
        'production_batch_id',
    ];

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function productionBatch(): BelongsTo
    {
        return $this->belongsTo(ProductionBatch::class);
    }

    public function manufacturerOrderPieces(): HasMany
    {
        return $this->hasMany(ManufacturerOrderPiece::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('production_orders.id', $text);
            }

            $query->orWhereHas('manufacturer.entity', function ($query) use ($text) {
                $query->where('entities.name', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('manufacturer_id')) {
            $query->where('production_orders.manufacturer_id', request('manufacturer_id'));
        }

        if (request()->filled('production_batch_id')) {
            $query->where('production_orders.production_batch_id', request('production_batch_id'));
        }

        return $query;
    }
}
