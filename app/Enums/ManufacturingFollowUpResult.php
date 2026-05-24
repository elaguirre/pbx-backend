<?php

namespace App\Enums;

enum ManufacturingFollowUpResult: string
{
    case CompletedPieces = 'completed_pieces';
    case CanceledPieces = 'canceled_pieces';
    case Blocking = 'blocking';
    case Warning = 'warning';
    case Info = 'info';

    public function label(): string
    {
        return match ($this) {
            self::CompletedPieces => 'Piezas completadas',
            self::CanceledPieces => 'Piezas canceladas',
            self::Blocking => 'Bloqueo',
            self::Warning => 'Advertencia',
            self::Info => 'Informativo',
        };
    }

    public function requiresDetails(): bool
    {
        return match ($this) {
            self::Blocking, self::Warning, self::Info => true,
            default => false,
        };
    }

    public function requiresQuantity(): bool
    {
        return match ($this) {
            self::CompletedPieces, self::CanceledPieces => true,
            default => false,
        };
    }
}
