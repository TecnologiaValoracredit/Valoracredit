<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction   ;
use App\Models\PermissionPermission;

class PermissionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions(["dashboard"], ["index"], false);
        $this->createPermissions(["users", "roles", "departaments"]);
		$this->createPermissions(["users"], ["changePassword","setNewPassword"], false);


		$this->createPermissions(["expedients"], ["index", "uploadExpedientsAbc", "update", "show"], false);
		$this->createPermissions(["exp_reports"], ["index"], false);

		$this->createPermissions(["chk_checklists"]);
		$this->createPermissions(["suppliers"]);
		$this->createPermissions(["branches"]);
		$this->createPermissions(["requisitions"]);

		$this->createPermissions(["s_sales"], ["index"], false);
		$this->createPermissions(["s_general_reports"], ["index"], false);
		$this->createPermissions(["s_institution_reports"], ["index"], false);
		$this->createPermissions(["s_mensual_reports"], ["index"], false);
		$this->createPermissions(["s_coordinator_reports"], ["index"], false);

		$this->createPermissions(["h_hardwares"]);
		$this->createPermissions(["h_device_types"]);
		$this->createPermissions(["h_brands"]);
		$this->createPermissions(["h_hardwares"],["generateQrCode"],false);
		
		$this->createPermissions(["f_fluxes"]);
		$this->createPermissions(["f_accounts"]);
		$this->createPermissions(["f_beneficiaries"]);
		$this->createPermissions(["f_fluxes"],["changeStats","showIncome","showExpenses"], false);
		$this->createPermissions(["f_flux_reports"],["index","exportAdminReport"], false);

		$this->createPermissions(["f_clasifications"]);
		$this->createPermissions(["f_cob_clasifications"]);
		$this->createPermissions(["s_coordinators"]);
		
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
