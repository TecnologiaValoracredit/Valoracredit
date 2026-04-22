<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RequisitionGlobalStatus;

class RequisitionGlobalStatus20042026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'Creada', 'description' => 'Creada, aún modificable', 'badge' => 'badge-created'],
            ['name' => 'Enviada a Administración y Contabilidad', 'description' => 'Enviada a revisión', 'badge' => 'badge-sent-admin-accounting'],
            ['name' => 'En Revisión', 'description' => 'En revisión por Administración y Contabilidad', 'badge' => 'badge-in-review'],
            ['name' => 'Revisada', 'description' => 'Revisada y lista para mandar a D.G.', 'badge' => 'badge-reviewed'],
            ['name' => 'Enviada a D.G.', 'description' => 'Enviada a revisión para D.G.', 'badge' => 'badge-sent-dg'],
            ['name' => 'Finalizada', 'description' => 'Finalizada y no modificable, todas las requisiciones han sido revisadas', 'badge' => 'badge-finalized'],
            ['name' => 'Modificada', 'description' => 'Modificada con nuevas requisiciones por checar', 'badge' => 'badge-modified'],
        ];

        foreach($values as $key => $value){
            RequisitionGlobalStatus::where('name', $value['name'])
                ->update([
                    'badge' => $value['badge'],
            ]);
        }
    }
}
