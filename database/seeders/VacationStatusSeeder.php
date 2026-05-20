<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VacationStatus;

class VacationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'Creada', 'description' => 'Vacación creada', 'badge' => 'badge-created'],
            ['name' => 'Cancelada', 'description' => 'Vacación cancelada', 'badge' => 'badge-cancelled'],
            ['name' => 'Aprobada', 'description' => 'Vacación aprovada', 'badge' => 'badge-approved'],
            ['name' => 'Rechazada', 'description' => 'Vacación rechazada', 'badge' => 'badge-rejected'],
            ['name' => 'Pendiente - RH', 'description' => 'Vacación pendiente de aprobación de Jefe Inmediato', 'badge' => 'badge-pending-boss'],
            ['name' => 'Pendiente - Jefe Inmediato', 'description' => 'Vacación pendiente de aprobación de RH', 'badge' => 'badge-pending-hr'],
        ];

        foreach ($values as $key => $value) {
            VacationStatus::create([
                'name' => $value['name'],
                'description' => $value['description'],
                'badge' => $value['badge'],
            ]);
        }
    }
}
