<?php

namespace App\Models;

use App\Enums\ManufacturingFollowUpResult;
use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManufacturingFollowUp extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $table = 'manufacturing_follow_up';

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'quantity', 'result', 'created_at'];
    protected $allowed_includes = [
        'manufacturerOrderPiece',
        'manufacturerOrderPiece.orderPiece',
        'manufacturerOrderPiece.orderPiece.piece',
        'user',
    ];

    protected $fillable = [
        'manufacturer_order_piece_id',
        'result',
        'details',
        'quantity',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
            'result' => ManufacturingFollowUpResult::class,
        ];
    }

    public function manufacturerOrderPiece(): BelongsTo
    {
        return $this->belongsTo(ManufacturerOrderPiece::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('manufacturing_follow_up.id', $text);
            }

            $query->orWhere('manufacturing_follow_up.details', 'like', "%{$text}%");
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('manufacturer_order_piece_id')) {
            $query->where(
                'manufacturing_follow_up.manufacturer_order_piece_id',
                request('manufacturer_order_piece_id'),
            );
        }

        return $query;
    }
}
