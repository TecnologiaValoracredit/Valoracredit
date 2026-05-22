<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VacationPolicy;

class VacationPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['years_from' => 0, 'years_to' => 1, 'days' => 0, 'advance_days' => 3, 'applicable_month_range' => 6],
            ['years_from' => 1, 'years_to' => 2, 'days' => 12, 'advance_days' => 3, 'applicable_month_range' => 18],
            ['years_from' => 2, 'years_to' => 3, 'days' => 14, 'advance_days' => 3, 'applicable_month_range' => 30],
            ['years_from' => 3, 'years_to' => 4, 'days' => 16, 'advance_days' => 3, 'applicable_month_range' => 42],
            ['years_from' => 4, 'years_to' => 5, 'days' => 18, 'advance_days' => 3, 'applicable_month_range' => 54],
        ];

        foreach ($values as $key => $value) {
            VacationPolicy::create([
                'years_from' => $value['years_from'],
                'years_to' => $value['years_to'],
                'days' => $value['days'],
                'advance_days' => $value['advance_days'],
                'applicable_month_range' => $value['applicable_month_range'],
            ]);
        }
    }
}
