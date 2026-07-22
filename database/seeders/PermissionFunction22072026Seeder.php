<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunction22072026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'approveAsBoss', 'description' => 'Permite firmar como Jefe Inmediato'],
        ];

        foreach($values as $key => $value){
            PermissionFunction::create([
                'name' => $value['name'],
                'description' => $value['description'],
            ]);
        }
    }
}
