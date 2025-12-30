<?php

namespace Database\Seeders;

use App\Models\DiscountCharacteristic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Permit;
use App\Models\Departament;
use App\Models\Motive;
use App\Models\JobPosition;
use App\Models\PermitStatus;

class PermitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_mock_user = User::where('name', 'Cesar Abraham Betancourt Chavez')->first();
        $second_mock_user = User::where('name', 'Iván Rodríguez Silva')->first();
        
        $mock_motive = Motive::where('id', 1)->first();
        $mock_discount_characteristic = DiscountCharacteristic::where('id', 1)->first();

        $values = [
            ['user_id' => $first_mock_user->id, 'departament_id' => $first_mock_user->departament->id, 'job_position_id' => $first_mock_user->jobPosition->id, "boss_id" => $first_mock_user->boss->id,
            'permit_date' => now(), 'entry_hour' => now(), 'exit_hour' => Carbon::tomorrow(), 'pending_hours' => 12, 'motive_id' => $mock_motive->id, 'discount_characteristic_id' => $mock_discount_characteristic->id,
            ],
            ['user_id' => $second_mock_user->id, 'departament_id' => $second_mock_user->departament->id, 'job_position_id' => $second_mock_user->jobPosition->id, "boss_id" => $second_mock_user->boss->id,
            'permit_date' => now(), 'entry_hour' => now(), 'exit_hour' => Carbon::tomorrow(), 'pending_hours' => 24, 'motive_id' => $mock_motive->id, 'discount_characteristic_id' => $mock_discount_characteristic->id,
            ],
        ];

        foreach ($values as $key => $value) {
            Permit::create([
                'user_id' => $value['user_id'],
                'departament_id' => $value['departament_id'],
                'job_position_id' => $value['job_position_id'],
                "boss_id" => $value['boss_id'],
                
                'permit_date' => $value['permit_date'],

                'entry_hour' => $value['entry_hour'],
                'exit_hour' => $value['exit_hour'],
                'pending_hours' => $value['pending_hours'],

                'motive_id' => $value['motive_id'],
                'discount_characteristic_id' => $value['discount_characteristic_id'],
            ]);
        }
    }
}
