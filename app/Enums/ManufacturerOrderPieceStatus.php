<?php

namespace App\Enums;

enum ManufacturerOrderPieceStatus: string
{
    case Pending = 'pending';
    case InProduction = 'in_production';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::InProduction => 'En fabricación',
            self::Completed => 'Completado',
        };
    }
}
