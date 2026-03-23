<?php

namespace App\Enums;

enum RequisitionGlobalStatusEnum : string{
    case CREATED = "Creada";
    case SENT_TO_ADMIN_AND_ACCOUNT = "Enviada a Administración y Contabilidad";
    case UNDER_REVIEW = "En Revisión";
    case REVIEWED = "Revisada";
    case SENT_TO_DG = "Enviada a D.G.";
    case FINALIZED = "Finalizada";
    case MODIFIED = "Modificada";
}

