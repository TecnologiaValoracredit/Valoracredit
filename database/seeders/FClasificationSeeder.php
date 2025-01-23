<?php

namespace Database\Seeders;

use App\Models\FClasification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FClasificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FClasification::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        ////INGRESOS////
        $f = FClasification::create([
            "name" => "WS PROMOTORA",
        ]);

        FClasification::create([
            "name" => "WS PROMOTORA",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Fondeo Fimubac",
        ]);


        FClasification::create([
            "name" => "Fondeo Fimubac",
            "parent_id" => $f->id,
        ]);

      
        FClasification::create([
            "name" => "Fondeo Fimubac",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Personas Fisicas",
        ]);

        FClasification::create([
            "name" => "Personas Fisicas",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Cobranza",
        ]);

        FClasification::create([
            "name" => "SECCION 5",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "SECCION 35",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "SECCION 21",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "SECCION 38",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "SECTOR SALUD NUEVO LEON",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "SECTOR SALUD FEDERAL COAHUILA",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "SECCION 50",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "AYUNTAMIENTO CENTRO TABASCO",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "SEDUZAC ZACATECAS",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "GOBIERNO DE TABASCO",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "SECCION 35",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "SECTOR SALUD DURANGO",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "IEA AGUASCALIENTES",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "SALUD BAJA CALIFORNIA",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "BAJA CALIFORNIA MAGISTERIO",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "BAJA CALIFORNIA GOBIERNO",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "TELESECUNDARIAS",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "BAJA CALIFORNIA CONGRESO",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "ISSSTECALI",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "AYUNTAMIENTO MEXICALI",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "AYUNTAMIENTO TIJUANA",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Intereses de Inversion",
        ]);

        FClasification::create([
            "name" => "Intereses de Inversion",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Liquidaciones y cobranza externa",
        ]);

        FClasification::create([
            "name" => "Liquidaciones y cobranza externa",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Cobranza Extrajudicial",
        ]);

        FClasification::create([
            "name" => "Cobranza Extrajudicial",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Cobranza Despacho",
        ]);

        FClasification::create([
            "name" => "Cobranza Despacho",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Ingresos por Domiciliar",
        ]);

        FClasification::create([
            "name" => "Ingresos por Domiciliar",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Otros Ingresos",
        ]);

        FClasification::create([
            "name" => "Otros Ingresos",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Retorno Estrategia",
        ]);

        FClasification::create([
            "name" => "Retorno Estrategia",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "GNP Defunciones",
        ]);

        FClasification::create([
            "name" => "GNP Defunciones",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "INGRESOS BIM DOMICILIADO",
        ]);

        FClasification::create([
            "name" => "INGRESOS BIM DOMICILIADO",
            "parent_id" => $f->id,
        ]);

      
        $f = FClasification::create([
            "name" => "Convenios",
        ]);

        FClasification::create([
            "name" => "Convenios",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Apoyos mensuales",
        ]);

        FClasification::create([
            "name" => "Apoyo SNTE 21",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Apoyo Baja California",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Apoyo SNTE 5",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Regalias",
        ]);

        FClasification::create([
            "name" => "Regalias",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Nomina",
        ]);

        FClasification::create([
            "name" => "Nomina WS Fiscal",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Nomina WS Complemento",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Nomina PIP",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Prestamos a empleados",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Colocación",
        ]);

        FClasification::create([
            "name" => "Dispersiones",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Reestructura de Clientes",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Comisiones",
        ]);

        FClasification::create([
            "name" => "Comisiones por venta",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Comisiones Cobranza",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Comisiones Telemarketing",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Reembolsos a Clientes",
        ]);

        FClasification::create([
            "name" => "Reembolsos a Clientes",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Capital a Fimubac",
        ]);

        FClasification::create([
            "name" => "Capital a Fimubac",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Intereses a Fimubac",
        ]);

        FClasification::create([
            "name" => "Intereses Fimubac",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Impuestos WS",
        ]);

        FClasification::create([
            "name" => "WS IVA e ISR",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "WS Imss, Infonavit y Afore",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "WS ISN 3%",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Impuestos PIP",
        ]);

        FClasification::create([
            "name" => "PIP IVA e ISR",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "PIP Imss, Infonavit y Afore",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "PIP ISN 3%",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Family & Friends",
        ]);

        FClasification::create([
            "name" => "Intereses PF",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Intereses HB",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Capital PF",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Gastos Operativos",
        ]);

        FClasification::create([
            "name" => "Gasto Operativo",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Activos fijos",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Consultoria SOFOM",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Comisiones por cobranza despacho",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Arrendamiento",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Bono Cobranza / Telemarketing",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Bono Comercial",
            "parent_id" => $f->id,
        ]);

        FClasification::create([
            "name" => "Limpieza",
            "parent_id" => $f->id,
        ]);


        FClasification::create([
            "name" => "ISR de Inversion",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Comision Banco",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Comision BIM",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Comision STP",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Honorarios Bim",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Computacion y Soporte",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Financiamiento Automotriz",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Gasolina",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Mensajeria",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Publicidad",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Renta de impresoras",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Safe Data",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Insumos oficina",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Mantenimiento de equipo de computo",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Mantenimiento de vehiculo",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Mantenimiento de Local",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Servicios",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Cajas Chicas",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Gastos de Viaje",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Finiquito",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Teams",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Gasto Operaciones",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Gasto Legal",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Gasto Comercial",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Gasto RH",
            "parent_id" => $f->id,
        ]);
        
        FClasification::create([
            "name" => "Credisoft",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Estrategia",
        ]);

        FClasification::create([
            "name" => "Estrategia",
            "parent_id" => $f->id,
        ]);

        $f = FClasification::create([
            "name" => "Reclamación Cargos Domiciliados",
        ]);

        FClasification::create([
            "name" => "Reclamación Cargos Domiciliados",
            "parent_id" => $f->id, 
        ]);

        $f = FClasification::create([
            "name" => "AMEX",
        ]);

        FClasification::create([
            "name" => "AMEX",
            "parent_id" => $f->id,
        ]);
        
       
    }
}
