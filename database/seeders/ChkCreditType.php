<?php

namespace Database\Seeders;

use App\Models\ChkCreditType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ChkCreditType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

     ChkCreditType::create(["name" => "Nuevo"]);
     ChkCreditType::create(["name" => "Reestructura"]);

    }
}
