<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;
use App\Models\PermissionPermissionRole;

class PermissionPermissionRole26012026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Consigue permisos de modulo de permisos y requisiciones que tienen en común
        $permit_permissions = $this->getPermissionPermissions(['permits'], [
            'changeStatus', 
            'send', 
            'sign', 
            'deny', 
            'exportPdf', 
        ]);

        //Asigna permisos al rol admin
        foreach ($permit_permissions as $permission ) {
            PermissionPermissionRole::create([
                'permission_id' => $permission->id,
                'role_id' => 1,
            ]);
        }

        //Consigue los permisos del modulo requisiciones
        $requisitions_permission_permissions = $this->getPermissionPermissions(['requisitions'], [
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
        ]);

        //Asigna los permisos al rol del admin
        foreach ($requisitions_permission_permissions as $permission) {
            PermissionPermissionRole::create([
                'permission_id' => $permission->id,
                'role_id' => 1,
            ]);
        }

        $reqGlobals_expTypes_fixedExp_permission_permissions = $this->getAllPermissionPermissionsFromModules([
            'requisition_globals',
            'expense_types',
            'fixed_expenses'
        ]);

        //Asigna los permisos al rol del admin
        foreach ($reqGlobals_expTypes_fixedExp_permission_permissions as $permission) {
            PermissionPermissionRole::create([
                'permission_id' => $permission->id,
                'role_id' => 1,
            ]);
        }

        $requisitionRows_permission_permission = $this->getPermissionPermissions(['requisition_rows'], ['getFields']);
        //Asigna los permisos al rol del admin
        foreach ($requisitionRows_permission_permission as $permission) {
            PermissionPermissionRole::create([
                'permission_id' => $permission->id,
                'role_id' => 1,
            ]);
        }
    }

    //HELPERS

    private function getPermissionPermissions($modules = [], $functions = []){
        $permission_permissions = [];
        $modules = PermissionModule::where('module_type_id', 2)->whereIn('name', $modules)->get();
        $functions = PermissionFunction::whereIn('name', $functions)->get();

        foreach ($modules as $key => $module) {
            foreach ($functions as $key => $function) {
                $permission_permission = PermissionPermission::where('module_id', $module->id)->where('function_id', $function->id)->first();
                array_push($permission_permissions, $permission_permission);
            }
        }

        return $permission_permissions;
    }

    private function getAllPermissionPermissionsFromModules($moduleNames = []){
        $modules = PermissionModule::whereIn('name', $moduleNames)->get('id');
        $permission_permissions = PermissionPermission::whereIn('module_id', $modules)->get();

        return $permission_permissions;
    }

}