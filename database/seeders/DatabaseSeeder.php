<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\PermissionModuleSeeder;
use Database\Seeders\PermissionFunctionSeeder;
use Database\Seeders\PermissionPermissionSeeder;
use Database\Seeders\PermissionPermissionRoleSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\ModuleTypeSeeder;
use Database\Seeders\DepartamentSeeder;
use Database\Seeders\InstitutionSeeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\AnchorerSeeder;
use Database\Seeders\ExpStatusSeeder;
use Database\Seeders\UbiStatusSeeder;
use Database\Seeders\ExpTypeSeeder;
use Database\Seeders\UbicationSeeder;
use Database\Seeders\ExpedientSeeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\RequisitionStatusSeeder;
use Database\Seeders\PaymentTypeSeeder;
use Database\Seeders\SSaleSeeder;
use Database\Seeders\CheckListSeeder;
use Database\Seeders\ChkCreditTypeSeeder; 
use Database\Seeders\ChkListSeeder;
use Database\Seeders\EmailAccountSeeder;
use Database\Seeders\HDeviceTypeSeeder;
use Database\Seeders\HBrandSeeder;

use Database\Seeders\FAccountSeeder;
use Database\Seeders\FBeneficiarySeeder;
use Database\Seeders\FMovementTypeSeeder;
use Database\Seeders\FStatusSeeder;
use Database\Seeders\FCobClasificationSeeder;
use Database\Seeders\SBranchSeeder;
use Database\Seeders\SCoordinatorSeeder;
use Database\Seeders\FCompanySeeder;
use Database\Seeders\FFluxSeeder;
use Database\Seeders\FClasificationSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\HHardwareSeeder;

use Database\Seeders\FCarteraStatusSeeder;
use Database\Seeders\PermissionPermissionSeeder31012025;
use Database\Seeders\PermissionFunction11032025Seeder;
use Database\Seeders\PermissionPermission11032025Seeder;
use Database\Seeders\Database25062025Seeder;
use Database\Seeders\Database17072025Seeder;
use Database\Seeders\Database18072025Seeder;
use Database\Seeders\BankSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            DepartamentSeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
            
            ModuleTypeSeeder::class,
            // PermissionModuleSeeder::class,
            PermissionFunctionSeeder::class,
            // PermissionPermissionSeeder::class,
            InstitutionSeeder::class,
            AnchorerSeeder::class,
            ExpStatusSeeder::class,
            UbiStatusSeeder::class,
            ExpTypeSeeder::class,
            UbicationSeeder::class,
            //ExpedientSeeder::class,
            SupplierSeeder::class,
            RequisitionStatusSeeder::class,
            PaymentTypeSeeder::class,
            SBranchSeeder::class,//Nuevo
            SCoordinatorSeeder::class,
            SCreditTypeSeeder::class,//NUEVO
            SSaleSeeder::class,
            ChkCreditTypeSeeder::class,
            ChkListSeeder::class,
            HDeviceTypeSeeder::class,
            HBrandSeeder::class,
            FCompanySeeder::class,
            FAccountSeeder::class,
            FBeneficiarySeeder::class,
            FMovementTypeSeeder::class,
            FStatusSeeder::class,
            FCobClasificationSeeder:: class,
            FClasificationSeeder:: class,
            CompanySeeder::class,
            HHardwareSeeder::class,
            FCarteraStatusSeeder::class,//NUEVO
            // PermissionPermissionSeeder31012025::class,

            // PermissionFunction11032025Seeder::class, //NUEVO
            // PermissionPermission11032025Seeder::class, //NUEVO
            FFluxSeeder:: class,
            Database25062025Seeder::class,
            Database18072025Seeder::class,
            PermissionPermissionRoleSeeder::class,
            
            // EmailAccountSeeder::class,
            // Database17072025Seeder::class
            BankSeeder::class,
            Database29072025Seeder::class,
        ]);
    }
}
