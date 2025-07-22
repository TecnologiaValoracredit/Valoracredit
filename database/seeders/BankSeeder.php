<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;


class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            'name'=> 'BBVA',
        ]);
        Bank::create([
            'name'=> 'Banorte',
        ]);
        Bank::create([
            'name'=> 'HSBC',
        ]);
        Bank::create([
            'name'=> 'Santander',
        ]);
        Bank::create([
            'name'=> 'Citibanamex',
        ]);
        Bank::create([
            'name'=> 'Banregio',
        ]);
        Bank::create([
            'name'=> 'Hey Banco',
        ]);
        Bank::create([
            'name'=> 'Banco Inbursa',
        ]);
        Bank::create([
            'name'=> 'NU',
        ]);
    }
}
