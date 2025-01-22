<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionFunction::create(
            ["name" => "index"],
        );
        PermissionFunction::create(
            ["name" => "create"],
        );
        PermissionFunction::create(
            ["name" => "store"],
        );
        PermissionFunction::create(
            ["name" => "edit"],
        );
        PermissionFunction::create(
            ["name" => "update"],
        );
        PermissionFunction::create(
            ["name" => "show"],
        );
        PermissionFunction::create(
            ["name" => "destroy"],
        );

        PermissionFunction::create([
            'name' => 'setNewPassword',
            'description' => 'Permiso para cambiar la contraseña de un usuario'
        ]);
        PermissionFunction::create([
            'name' => 'changePassword',
            'description' => 'Permiso para cambiar la contraseña de un usuario'
        ]);
        PermissionFunction::create([
            'name' => 'changeStats',
            'description' => 'Permiso para cambiar el estado de flujo'
        ]);
        PermissionFunction::create([
            'name' => 'showIncome',
            'description' => 'Permiso para ver ingresos'
        ]);
        PermissionFunction::create([
            'name' => 'showExpenses',
            'description' => 'Permiso para ver egresos'
        ]);

        PermissionFunction::create(["name" => "uploadExpedientsAbc"]);
        PermissionFunction::create(["name" => "getDataAutocomplete"]);

    }
}
