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
        $banks = [
            'BBVA México',
            'Banorte',
            'Santander México',
            'Citibanamex',
            'HSBC México',
            'Scotiabank México',
            'Inbursa',
            'Banregio',
            'Afirme',
            'Banco del Bajío',
            'Banco Azteca',
            'BanCoppel',
            'Monex',
            'Invex',
            'Interacciones',
            'JP Morgan México',
            'Deutsche Bank México',
            'Barclays Bank México',
            'Bancomext',
            'Compartamos Banco',
            'Bansi',
            'Hey Banco',
            'NU Banco',
            // puedes agregar otros bancos como Ve por Más, Volkswagen Bank, etc.
        ];

        foreach ($banks as $name) {
            Bank::create([
                'name' => $name,
            ]);
        }
    }
}
