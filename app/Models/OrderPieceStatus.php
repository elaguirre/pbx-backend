<?php

namespace App\Models;

use App\Enums\OrderPieceStatusRole;
use App\Models\Traits\HasQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderPieceStatus extends Model
{
    use HasFactory;
    use HasQueryBuilder;

    protected $default_sorts = ['order'];
    protected $allowed_sorts = ['order', 'id', 'name', 'role'];
    protected $fillable = [
        'name',
        'details',
        'role',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'role' => OrderPieceStatusRole::class,
            'order' => 'integer',
        ];
    }

    public function orderPieces(): HasMany
    {
        return $this->hasMany(OrderPiece::class);
    }

    public function scopeAdvancedSearch($query)
    {
        if (! request()->filled('sort')) {
            $query->orderBy('order_piece_statuses.order');
        }

        if (request()->filled('role')) {
            $role = OrderPieceStatusRole::tryFrom(request('role'));

            if ($role) {
                $query->where('order_piece_statuses.role', $role);
            }
        }

        return $query;
    }

    public function scopeSearch($query, $text)
    {
        if (! $text) {
            return $query;
        }

        return $query->where(function ($query) use ($text) {
            if (is_numeric($text)) {
                $query->where('order_piece_statuses.id', $text);
            }

            $query->orWhere('order_piece_statuses.name', 'like', "%{$text}%")
                ->orWhere('order_piece_statuses.details', 'like', "%{$text}%");
        });
    }

    public static function idForRole(OrderPieceStatusRole $role): ?int
    {
        $id = static::query()->where('role', $role)->value('id');

        return $id ? (int) $id : null;
    }

    public static function initialId(): ?int
    {
        $id = static::idForRole(OrderPieceStatusRole::Initial);

        if ($id) {
            return $id;
        }

        $first = static::query()->orderBy('order')->orderBy('id')->value('id');

        return $first ? (int) $first : null;
    }

    public static function idsForRole(OrderPieceStatusRole $role): array
    {
        return static::query()
            ->where('role', $role)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    public static function shippableStatusIds(): array
    {
        return static::idsForRole(OrderPieceStatusRole::Shippable);
    }
}
