<?php

namespace Database\Seeders;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
$holidays = [
            // 2026
            [
                'name' => 'Año Nuevo',
                'description' => 'Primer día del año',
                'date' => '2026-01-01',
            ],
            [
                'name' => 'Día de la Constitución',
                'description' => 'Conmemoración de la Constitución Mexicana',
                'date' => '2026-02-02',
            ],
            [
                'name' => 'Natalicio de Benito Juárez',
                'description' => 'Día festivo oficial',
                'date' => '2026-03-16',
            ],
            [
                'name' => 'Día del Trabajo',
                'description' => 'Día internacional de los trabajadores',
                'date' => '2026-05-01',
            ],
            [
                'name' => 'Día de la Independencia',
                'description' => 'Conmemoración de la Independencia de México',
                'date' => '2026-09-16',
            ],
            [
                'name' => 'Revolución Mexicana',
                'description' => 'Conmemoración de la Revolución Mexicana',
                'date' => '2026-11-16',
            ],
            [
                'name' => 'Navidad',
                'description' => 'Celebración de Navidad',
                'date' => '2026-12-25',
            ],

            // 2027
            [
                'name' => 'Año Nuevo',
                'description' => 'Primer día del año',
                'date' => '2027-01-01',
            ],
            [
                'name' => 'Día de la Constitución',
                'description' => 'Conmemoración de la Constitución Mexicana',
                'date' => '2027-02-01',
            ],
            [
                'name' => 'Natalicio de Benito Juárez',
                'description' => 'Día festivo oficial',
                'date' => '2027-03-15',
            ],
            [
                'name' => 'Día del Trabajo',
                'description' => 'Día internacional de los trabajadores',
                'date' => '2027-05-01',
            ],
            [
                'name' => 'Día de la Independencia',
                'description' => 'Conmemoración de la Independencia de México',
                'date' => '2027-09-16',
            ],
            [
                'name' => 'Revolución Mexicana',
                'description' => 'Conmemoración de la Revolución Mexicana',
                'date' => '2027-11-15',
            ],
            [
                'name' => 'Navidad',
                'description' => 'Celebración de Navidad',
                'date' => '2027-12-25',
            ],
        ];

        $user = User::where('email', 'auxtecnologia@valoracredit.mx')->first();

        foreach ($holidays as $holiday) {
            Holiday::create([
                ...$holiday,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}
