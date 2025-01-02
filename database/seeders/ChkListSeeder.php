<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ChkList;
use Illuminate\Database\Seeder;

class ChkListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar varias descripciones predeterminadas
        ChkList::create([
            'description' => 'DOCUMENTOS PERSONALES CARGADOS EN SISTEMA 
            (ID OFICIAL, TALONES DE NOMINA, COMPROBANTE DE DOMICILIO, CUENTA DEL CLIENTE.',
        ]);

        ChkList::create([
            'description' => 'CORRECTA CAPTURA DE NOMBRE DE CLIENTE Y RFC EN CREDISOFT.',
        ]);

        ChkList::create([
            'description' => 'PROCESO DE VALIDACION TELEFONICA COMPLETO.',
        ]);
        ChkList::create([
            'description' => 'CARGA COMPLETA DE EXPEDIENTE DEL CLIENTE EN CREDISOFT',
        ]);
        ChkList::create([
            'description' => 'FIRMA COMPLETA DEL EXPEDIENTE',
        ]);
        ChkList::create([
            'description' => 'DOCUMENTOS NECESARIOS PARA LA INSTALACION DEL CREDITO CARGADOS EN CREDISOFT.',
        ]);



    }
}
