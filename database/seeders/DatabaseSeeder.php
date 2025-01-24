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
use Database\Seeders\SCoordinatorSeeder;
use Database\Seeders\FCompanySeeder;
use Database\Seeders\FFluxSeeder;
use Database\Seeders\FClasificationSeeder;


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
            PermissionModuleSeeder::class,
            PermissionFunctionSeeder::class,
            PermissionPermissionSeeder::class,
            PermissionPermissionRoleSeeder::class,
            MenuSeeder::class,
            InstitutionSeeder::class,
            AnchorerSeeder::class,
            ExpStatusSeeder::class,
            UbiStatusSeeder::class,
            ExpTypeSeeder::class,
            UbicationSeeder::class,
           // ExpedientSeeder::class,
            SupplierSeeder::class,
            RequisitionStatusSeeder::class,
            PaymentTypeSeeder::class,
            SCoordinatorSeeder::class,
            // SSaleSeeder::class,
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

            FFluxSeeder:: class,

            // EmailAccountSeeder::class,

        ]);
    }
}
