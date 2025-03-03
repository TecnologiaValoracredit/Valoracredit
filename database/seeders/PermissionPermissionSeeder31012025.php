<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction   ;
use App\Models\PermissionPermission;

class PermissionPermissionSeeder31012025 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	
    {
		//Crear permisos de función
		
		PermissionFunction::create([
            'name' => 'exportFluxReport',
            'description' => 'Exportar reporte de flujos '
        ]);


		//Crear permisos
        
		$this->createPermissions(["f_flux_reports"],["index","exportFluxReport"], false);



		

		
		
    }

    public function createPermissions($moduleNames = [], $functionNames = [], $addCrudFunctions = true) {
		$defaultFunctions = ["index","store","create","show","update","destroy","edit"];
		$modules = PermissionModule::where("module_type_id", 2)->whereIn("name", $moduleNames)->get();
		if($addCrudFunctions) {
			$functionNames = array_merge($defaultFunctions, $functionNames);
		}
		$functions = PermissionFunction::whereIn("name", $functionNames)->get();
		
		foreach ($modules as $key => $module) {
			foreach ($functions as $key => $function) {
				PermissionPermission::create(["module_id" => $module->id, "function_id" => $function->id]);
			}
		}
	}
}
