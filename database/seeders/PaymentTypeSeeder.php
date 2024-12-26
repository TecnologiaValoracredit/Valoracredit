<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentType;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            'name'=> 'Transferencia', 
        ]);

        PaymentType::create([
            'name'=> 'Efectivo',
          
        ]);
        PaymentType::create([
            'name'=> 'Pago con tarjeta fisica',
            
        ]);

    }
}
