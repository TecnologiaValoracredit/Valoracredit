<?php

namespace App\Enums;

enum VacationStatusEnum : string{
    case CREATED = "Creada";
    case CANCELLED = "Cancelada";
    case APPROVED = "Aprobada";
    case REJECTED = "Rechazada";
    case PENDING_HR = "Pendiente - RH";
    case PENDING_BOSS = "Pendiente - Jefe Inmediato";
}

