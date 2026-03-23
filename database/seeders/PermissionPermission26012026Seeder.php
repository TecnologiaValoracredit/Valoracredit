<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;

class PermissionPermission26012026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions(['permits'], ['changeStatus', 'send', 'sign', 'deny', 'exportPdf'], false);
        $this->createPermissions(['requisitions'], [
			'changeStatus',
			'send',
			'deny',
			'cancel',
			'return',
			'chargePolicy',
			'payment',
			'uploadPayment',
			'boss',
			'treasury',
			'accounting',
			'administration',
			'dg',
			'review',
			'approve',
			'exportPdf',
		],false);
		$this->createPermissions(['requisition_globals'], ['changeStatus', 'updateStatus', 'send', 'review', 'approve', 'adminSignature', 'exportPdf']);

        $this->createPermissions(['expense_types', 'fixed_expenses']);
        $this->createPermissions(['fixed_expenses', 'requisition_rows'], ['getFields'], false);
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
