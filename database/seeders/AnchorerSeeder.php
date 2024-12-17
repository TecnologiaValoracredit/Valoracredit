<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anchorer;

class AnchorerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Anchorer::create(["name" => "PLAN IP"]);
        Anchorer::create(["name" => "PLAN IP-SAPI"]);
        Anchorer::create(["name" => "WS PROMOTORA"]);
    }
}
