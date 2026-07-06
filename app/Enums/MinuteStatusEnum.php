<?php

namespace App\Enums;

enum MinuteStatusEnum: string
{
    case OPEN     = 'open';
    case CLOSED   = 'closed';
    case CANCELED = 'canceled';

    public static function labels(): array
    {
        return [
            self::OPEN->value     => 'Abierta',
            self::CLOSED->value   => 'Cerrada',
            self::CANCELED->value => 'Cancelada',
        ];
    }
}
