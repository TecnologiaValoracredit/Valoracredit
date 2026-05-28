<?php

namespace App\Enums;

enum RolesEnum : string {
    case ADMIN = "Admin";
    case DG = "Dirección general";
    case TREASURY = "Tesorería";
    case HR = "Recursos Humanos";
}
