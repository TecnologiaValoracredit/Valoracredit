<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SBranch;

class SBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SBranch::create([
            'name'=> 'B1 EDUARDO MEZA',
            'segment' => '2104',
            'accounting_account' => '50401001'
        ]);

        SBranch::create([
            'name'=> 'B3 ERICK VILLEGAS',
            'segment' => '2600',
            'accounting_account' => '50401001'
        ]);

        SBranch::create([
            'name'=> 'B4 MARIO ALANIS',
            'segment' => '2104',
            'accounting_account' => '50401001'
        ]);

        SBranch::create([
            'name'=> 'B5 CHRISTIAN EDUARDO GARCIA',
        ]);

        SBranch::create([
            'name'=> 'MATRIZ',
            'segment' => '2101',
            'accounting_account' => '50401001'
        ]);

        SBranch::create([
            'name'=> 'MEXICALI',
            'segment' => '2600',
            'accounting_account' => '50401001'
        ]);

        SBranch::create([
            'name'=> 'TELEMARKETING MATRIZ',
            'segment' => '2101',
            'accounting_account' => '50401001'
        ]);

        SBranch::create([
            'name'=> 'TIJUANA',
            'segment' => '2101',
            'accounting_account' => '50401001'
        ]);

        SBranch::create([
            'name'=> 'TORREON',
            'segment' => '2201',
            'accounting_account' => '50401001'
        ]);

        SBranch::create([
            'name'=> 'SALTILLO',
            'segment' => '2200',
            'accounting_account' => '50401001'
        ]);
       
    }
}
