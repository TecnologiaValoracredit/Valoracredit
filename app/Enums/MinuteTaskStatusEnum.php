<?php

namespace App\Enums;

enum MinuteTaskStatusEnum: string
{
    case PENDING     = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED   = 'completed';
    case CANCELED    = 'canceled';

    public static function labels(): array
    {
        return [
            self::PENDING->value     => 'Pendiente',
            self::IN_PROGRESS->value => 'En progreso',
            self::COMPLETED->value   => 'Completada',
            self::CANCELED->value    => 'Cancelada',
        ];
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING     => 'badge-warning',
            self::IN_PROGRESS => 'badge-info',
            self::COMPLETED   => 'badge-success',
            self::CANCELED    => 'badge-danger',
        };
    }
}
