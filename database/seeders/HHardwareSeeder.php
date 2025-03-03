<?php

namespace Database\Seeders;

use App\Models\HHardware;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HHardwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HHardware::create([
            "user_id" => "1",
            "h_device_type_id" => "1",
            "h_brand_id" => "1",
            "serial_number" => "5CG3250P4Y",
            "specifications" => "Core i5, 8Gb de ram",
            "purchase_date" =>  Carbon::create(2023, 12, 27, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Gris"

        ]);
        HHardware::create([
            "user_id" => "2",
            "h_device_type_id" => "1",
            "h_brand_id" => "4",
            "serial_number" => "9S714D33410402M1080",
            "specifications" => "Core i7, 8Gb de ram",
            "purchase_date" =>  Carbon::create(2023, 02, 15, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Negra"

        ]);

        HHardware::create([
            "user_id" => "3",
            "h_device_type_id" => "2",
            "h_brand_id" => "100",
            "serial_number" => "1C-1B-0D-98-09-4C",
            "specifications" => "Core i7, 12Gb de ram",
            "purchase_date" =>  Carbon::create(2024, 12, 02, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Negra"

        ]);

        HHardware::create([
            "user_id" => "4",
            "h_device_type_id" => "1",
            "h_brand_id" => "2",
            "serial_number" => "PF1LXY2Y",
            "specifications" => "Ryzen 3, 16Gb de ram",
            "purchase_date" =>  Carbon::create(2019, 06, 01, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Gris"

        ]);

        HHardware::create([
            "user_id" => "6",
            "h_device_type_id" => "1",
            "h_brand_id" => "3",
            "serial_number" => "HOKBLB3",
            "specifications" => "Core i5, 8Gb de ram",
            "purchase_date" =>  Carbon::create(2021, 03, 28, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Gris"

        ]);

        HHardware::create([
            "user_id" => "7",
            "h_device_type_id" => "1",
            "h_brand_id" => "1",
            "serial_number" => "70-66-55-2D-E1-32",
            "specifications" => "Pentium, 8Gb de ram",
            "purchase_date" =>  Carbon::create(2020, 07, 06, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Magenta"

        ]);

        HHardware::create([
            "user_id" => "8",
            "h_device_type_id" => "1",
            "h_brand_id" => "2",
            "serial_number" => "00-45-E2-4C-38-A4",
            "specifications" => "Core i5, 8Gb de ram",
            "purchase_date" =>  Carbon::create(2023, 02, 28, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Gris"

        ]);

        HHardware::create([
            "user_id" => "9",
            "h_device_type_id" => "1",
            "h_brand_id" => "2",
            "serial_number" => "YD06DG88",
            "specifications" => "Core i5, 4Gb de ram",
            "purchase_date" =>  Carbon::create(2021, 03, 18, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Blanca"

        ]);

        HHardware::create([
            "user_id" => "10",
            "h_device_type_id" => "1",
            "h_brand_id" => "1",
            "serial_number" => "5CG0349CC",
            "specifications" => "Ryzen 5, 16Gb de ram",
            "purchase_date" =>  Carbon::create(2023, 03, 02, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Blanco"

        ]);

        HHardware::create([
            "user_id" => "11",
            "h_device_type_id" => "1",
            "h_brand_id" => "1",
            "serial_number" => "5CG3062574",
            "specifications" => "Core i5, 8Gb de ram",
            "purchase_date" =>  Carbon::create(2021, 03, 18, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Gris"

        ]);

        HHardware::create([
            "user_id" => "12",
            "h_device_type_id" => "2",
            "h_brand_id" => "5",
            "serial_number" => "C02DN7W07DW",
            "specifications" => "Core i5, 8Gb de ram",
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Gris"

        ]);

        HHardware::create([
            "user_id" => "13",
            "h_device_type_id" => "1",
            "h_brand_id" => "3",
            "serial_number" => "2C-9C-58-29-C5-1F",
            "specifications" => "Core i5, 16Gb de ram",
            "purchase_date" =>  Carbon::create(2024, 12, 16, 10, 0, 0),
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Gris"

        ]);

        HHardware::create([
            "user_id" => "14",
            "h_device_type_id" => "1",
            "h_brand_id" => "1",
            "serial_number" => "CND324FKM",
            "specifications" => "Core i5, 16Gb de ram",
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Negro"

        ]);

        HHardware::create([
            "user_id" => "15",
            "h_device_type_id" => "1",
            "h_brand_id" => "1",
            "serial_number" => "CND0426972",
            "specifications" => "Core i7, 8Gb de ram",
            "branch_id" => "1",
            "company_id" => "1",
            "color" => "Negro"

        ]);

        



        



        
    }
}
