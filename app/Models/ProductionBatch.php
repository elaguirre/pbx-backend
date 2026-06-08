<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionBatch extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'created_at'];
    protected $allowed_includes = [
        'productionOrders',
        'productionOrders.manufacturer',
        'productionOrders.manufacturer.entity',
    ];

    protected $fillable = [];

    public function productionOrders(): HasMany
    {
        return $this->hasMany(ProductionOrder::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        if (is_numeric($text)) {
            return $query->where('production_batches.id', $text);
        }

        return $query;
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->boolean('with_production_orders_count')) {
            $query->withCount('productionOrders as production_orders_count');
        }

        return $query;
    }
}
