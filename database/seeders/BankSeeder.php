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
            ['name' => 'Citibanamex',       'bank_code' => '002'],
            ['name' => 'BBVA México',       'bank_code' => '012'],
            ['name' => 'Santander México',  'bank_code' => '014'],
            ['name' => 'Banjército',        'bank_code' => '019'],
            ['name' => 'HSBC México',       'bank_code' => '021'],
            ['name' => 'Banco del Bajío',   'bank_code' => '030'],
            ['name' => 'Inbursa',           'bank_code' => '036'],
            ['name' => 'Interacciones',     'bank_code' => '037'],
            ['name' => 'Mifel',             'bank_code' => '042'],
            ['name' => 'Scotiabank México', 'bank_code' => '044'],
            ['name' => 'Banregio',          'bank_code' => '058'],
            ['name' => 'Invex',             'bank_code' => '059'],
            ['name' => 'Bansi',             'bank_code' => '060'],
            ['name' => 'Afirme',            'bank_code' => '062'],
            ['name' => 'Banorte',           'bank_code' => '072'],
            ['name' => 'Bank of America México', 'bank_code' => '106'],
            ['name' => 'JP Morgan México',  'bank_code' => '110'],
            ['name' => 'Monex',             'bank_code' => '112'],
            ['name' => 'Banco Ve por Más',  'bank_code' => '113'],
            ['name' => 'Banco Azteca',      'bank_code' => '127'],
            ['name' => 'Autofin México',    'bank_code' => '128'],
            ['name' => 'Barclays México',   'bank_code' => '129'],
            ['name' => 'Compartamos Banco', 'bank_code' => '130'],
            ['name' => 'Multiva Banco',     'bank_code' => '132'],
            ['name' => 'Actinver',          'bank_code' => '133'],
            ['name' => 'NU Banco',          'bank_code' => '906'],
            ['name' => 'Hey Banco',         'bank_code' => '167'], // Hey Banco (Banregio digital) :contentReference[oaicite:0]{index=0}
        ];

        foreach ($banks as $bank) {
            Bank::firstOrCreate(
                ['bank_code' => $bank['bank_code']],
                ['name' => $bank['name']]
            );
        }
    }
}
