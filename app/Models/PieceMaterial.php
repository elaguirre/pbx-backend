<?php

namespace App\Models;

use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PieceMaterial extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['-id'];
    protected $allowed_sorts = ['id', 'quantity', 'created_at'];
    protected $allowed_includes = ['piece', 'material'];

    protected $fillable = [
        'piece_id',
        'material_id',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
        ];
    }

    public function piece(): BelongsTo
    {
        return $this->belongsTo(Piece::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('piece_materials.id', $text);
            }

            $query->orWhereHas('material', function ($query) use ($text) {
                $query->where('materials.name', 'like', "%{$text}%")
                    ->orWhere('materials.uom', 'like', "%{$text}%");
            });
        });
    }

    public function scopeAdvancedSearch($query)
    {
        if (request()->filled('piece_id')) {
            $query->where('piece_materials.piece_id', request('piece_id'));
        }

        if (request()->filled('material_id')) {
            $query->where('piece_materials.material_id', request('material_id'));
        }

        return $query;
    }
}
