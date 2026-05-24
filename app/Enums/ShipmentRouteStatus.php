<?php

namespace App\Enums;

enum ShipmentRouteStatus: string
{
    case Pending = 'pending';
    case Complete = 'complete';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::Complete => 'Completo',
        };
    }
}
