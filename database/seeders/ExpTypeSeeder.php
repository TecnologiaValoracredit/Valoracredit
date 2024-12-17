<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpType;

class ExpTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpType::create(["name" => "FIRMA DIGITAL"]);
        ExpType::create(["name" => "FIRMA AUTOGRAFA"]);

    }
}
