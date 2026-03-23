<?php

namespace Database\Seeders;

use App\Models\RequisitionGlobalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequisitionGlobalStatusSeeder extends Seeder
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
            ['name' => 'Enviada a Administración y Contabilidad', 'description' => 'Enviada a revisión', 'badge' => 'badge-sent'],
            ['name' => 'En Revisión', 'description' => 'En revisión por Administración y Contabilidad', 'badge' => 'badge-review'],
            ['name' => 'Revisada', 'description' => 'Revisada y lista para mandar a D.G.', 'badge' => 'badge-reviewed'],
            ['name' => 'Enviada a D.G.', 'description' => 'Enviada a revisión para D.G.', 'badge' => 'badge-sent'],
            ['name' => 'Finalizada', 'description' => 'Finalizada y no modificable, todas las requisiciones han sido revisadas', 'badge' => 'badge-finalized'],
            ['name' => 'Modificada', 'description' => 'Modificada con nuevas requisiciones por checar', 'badge' => 'badge-modified'],
        ];

        foreach($values as $key => $value){
            RequisitionGlobalStatus::create([
                'name' => $value['name'],
                'description' => $value['description'],
                'badge' => $value['badge'],
            ]);
        }
    }
}
