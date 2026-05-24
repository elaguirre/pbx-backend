<?php

namespace App\Enums;

enum OrderStatus: int
{
    case Started = 0;
    case InProgress = 1;
    case Completed = 2;
    case Sent = 3;
    case Delivered = 4;
    case Paid = 5;

    public function label(): string
    {
        return match ($this) {
            self::Started => 'Iniciado',
            self::InProgress => 'En proceso',
            self::Completed => 'Completado',
            self::Sent => 'Enviado',
            self::Delivered => 'Entregado',
            self::Paid => 'Pagado',
        };
    }
}
