<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunction19052026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'seeAllVacations', 'description' => 'Ver todas las vacaciones solicitadas por los usuarios'],
        ];

        foreach($values as $key => $value){
            PermissionFunction::create([
                'name' => $value['name'],
                'description' => $value['description'],
            ]);
        }
    }
}
