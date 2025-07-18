<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;
use App\Models\RIndicator;
use App\Models\Institution;

use Carbon\Carbon;

class RIndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds. 
     *
     * @return void
     */
    public function run()
    {
        $file = base_path("resources/indicadores_17072025.xlsx");
        $pages = Excel::toArray(new ExcelImport(), $file); 
        foreach($pages[0] as $key =>$row)
        {
            if ($key > 0) {
                $z = is_numeric($row[25]) ? date('Y-m-d', ($row[25] - 25568) * 86400) : null;
                $al = is_numeric($row[34]) ? date('Y-m-d', ($row[34] - 25568) * 86400) : null;
                $an = is_numeric($row[39]) ? date('Y-m-d', ($row[39] - 25568) * 86400) : null;

                $fecha = Carbon::parse('2024-01-01')->format('Y-m-d');

                $institution = Institution::where("name", trim($row[10]))->first();
                if ($institution == null) {
                    $institution = Institution::create(["name" => trim($row[10])]);
                }
                RIndicator::create([
                    'institution_id' => $institution->id,
                    'credit_id' => trim($row[0]), 
                    'matching_captial' => trim($row[1]), 
                    'total_portfolio' => trim($row[4]), 
                    'cut_date' => $z,
                    'portfolio_date' => $al,
                    'last_move_date' => $an,
                    'upload_date' => $fecha
                ]);
            }
        }
    }

}
