<?php

namespace App\Enums;

enum OrderPieceStatusRole: string
{
    case Initial = 'initial';
    case Packable = 'packable';
    case Shippable = 'shippable';

    public function label(): string
    {
        return match ($this) {
            self::Initial => 'Inicial',
            self::Packable => 'Empaquetable',
            self::Shippable => 'Embarcable',
        };
    }
}
