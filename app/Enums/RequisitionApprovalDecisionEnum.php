<?php

namespace App\Enums;

enum RequisitionApprovalDecisionEnum : string{
    case APPROVED = "Aprobada";
    case DENIED = "Rechazada";
    case RETURNED = "Devuelta";
}

