<?php

namespace App\Enums;

enum RequisitionOwnerPermissionEnum : string{
    case BOSS = "requisitions.boss";
    case TREASURY = "requisitions.treasury";
    case ACCOUNTING = "requisitions.accounting";
    case ADMINISTRATION = "requisitions.administration";
    case DG = "requisitions.dg";
    case GLOBALS = "requisitions.globals";
}

