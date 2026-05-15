<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RequisitionGlobalStatus;

class RequisitionGlobalStatus14052026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'En revisión - D.G.', 'description' => 'En revisión por D.G.', 'badge' => 'badge-in-review-dg'],
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
