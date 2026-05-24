<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPiece extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'quantity', 'created_at'];
    protected $allowed_includes = ['product', 'piece'];

    protected $fillable = [
        'product_id',
        'piece_id',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function piece(): BelongsTo
    {
        return $this->belongsTo(Piece::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('product_pieces.id', $text);
            }

            $query->orWhereHas('piece', function ($query) use ($text) {
                $query->where('pieces.name', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('product_id')) {
            $query->where('product_pieces.product_id', request('product_id'));
        }

        if (request()->filled('piece_id')) {
            $query->where('product_pieces.piece_id', request('piece_id'));
        }

        return $query;
    }
}
