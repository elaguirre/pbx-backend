<?php

namespace App\Enums;

enum ShipmentOrderPieceStatus: string
{
    case Pending = 'pending';
    case Delivered = 'delivered';
    case Returned = 'returned';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Delivered => 'Entregado',
            self::Returned => 'Devuelto',
        };
    }
}
