<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManufacturerPieceCost extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $table = 'manufacturer_pieces_cost';

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'price', 'created_at'];
    protected $allowed_includes = ['manufacturer', 'manufacturer.entity', 'piece'];

    protected $fillable = [
        'manufacturer_id',
        'piece_id',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
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
                $query->where('manufacturer_pieces_cost.id', $text);
            }

            $query->orWhereHas('piece', function ($query) use ($text) {
                $query->where('pieces.name', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('manufacturer_id')) {
            $query->where('manufacturer_pieces_cost.manufacturer_id', request('manufacturer_id'));
        }

        if (request()->filled('piece_id')) {
            $query->where('manufacturer_pieces_cost.piece_id', request('piece_id'));
        }

        return $query;
    }
}
