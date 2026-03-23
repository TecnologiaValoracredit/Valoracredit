<?php

namespace App\Enums;

enum RequisitionStatusEnum : string{
    case CREATED = "Creada";
    case CANCELLED = "Cancelada";
    case SENT_TO_BOSS = "Enviada a Jefe Inmediato";
    case RETURNED_BY_BOSS = "Devuelta por Jefe Inmediato";
    case DENIED_BY_BOSS = "Rechazada por Jefe Inmediato";
    case AUTHORIZED_BY_BOSS = "Aprobada por Jefe Inmediato";

    CASE SENT_TO_TREASURY = "Enviada a Tesoreria";
    case UNDER_REVIEW_BY_TREASURY = "En revisión - Tesoreria";
    case STAND_BY_TREASURY = "En espera - Tesoreria";
    case RETURNED_BY_TREASURY = "Devuelta por Tesoreria";

    case SENT_TO_ACCOUNTING = "Enviada a Contabilidad";
    case POLICY_CHARGED = "Poliza cargada";
    case DENIED_BY_ACCOUNTING = "Rechazada por Contabilidad";

    case GLOBAL_REVIEW = "Revisión Global";
    case RETURNED_BY_GLOBAL_REVIEW = "Devuelta de Revisión Global";

    case DENIED_BY_ADMINISTRATION = "Rechazada por Administración";
    
    case SENT_TO_DG = "Enviada a D.G.";
    case READY_FOR_DG = "Lista para D.G.";
    case UNDER_REVIEW_BY_DG = "En revisión - D.G.";
    case AUTHORIZED_BY_DG = "Autorizada por D.G.";
    case RETURNED_BY_DG = "Devuelta por D.G.";
    case DENIED_BY_DG = "Rechazada por D.G.";
    case PAID = "Pagada";
}

