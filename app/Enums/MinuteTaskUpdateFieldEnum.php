<?php

namespace App\Enums;

enum MinuteTaskUpdateFieldEnum: string
{
    case STATUS = 'status';
    case ASSIGNED_TO = 'assigned_to';
    case DUE_DATE = 'due_date';
    case PRIORITY = 'priority';
    case PROGRESS = 'progress';

    public static function labels(): array
    {
        return [
            self::STATUS->value => 'Estatus',
            self::ASSIGNED_TO->value => 'Responsable',
            self::DUE_DATE->value => 'Fecha compromiso',
            self::PRIORITY->value => 'Prioridad',
            self::PROGRESS->value => 'Avance',
        ];
    }

    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }

    public static function labelFor(?string $value): string
    {
        if (is_null($value)) {
            return 'Campo';
        }

        return self::labels()[$value] ?? $value;
    }
}
