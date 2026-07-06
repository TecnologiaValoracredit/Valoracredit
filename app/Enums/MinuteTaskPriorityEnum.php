<?php

namespace App\Enums;

enum MinuteTaskPriorityEnum: string
{
    case LOW    = 'low';
    case MEDIUM = 'medium';
    case HIGH   = 'high';
    case URGENT = 'urgent';

    public static function labels(): array
    {
        return [
            self::LOW->value    => 'Baja',
            self::MEDIUM->value => 'Media',
            self::HIGH->value   => 'Alta',
            self::URGENT->value => 'Urgente',
        ];
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::LOW    => 'badge-secondary',
            self::MEDIUM => 'badge-info',
            self::HIGH   => 'badge-warning',
            self::URGENT => 'badge-danger',
        };
    }
}
