<?php

namespace Database\Seeders;

use App\Models\UserContract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contract;

class UserContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mockUser = User::where('name', 'Cesar')->first();
        $trialContract = Contract::where('name', 'Contrato de prueba')->first();
        $permanentContract = Contract::where('name', 'Contrato de planta')->first();

        $values = [
            ['user_id' => $mockUser->id, 'contract_id' => $trialContract->id],
            ['user_id' => $mockUser->id, 'contract_id' => $permanentContract->id],
        ];

        foreach ($values as $key => $value){
            UserContract::create([
                'user_id' => $value['user_id'],
                'contract_id' => $value['contract_id'],
            ]);
        }
    }
}
