<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\ExpedientController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ExpReportController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\ChkChecklistController;
use App\Http\Controllers\SSaleController;
use App\Http\Controllers\SGeneralReportController;
use App\Http\Controllers\SMensualReportController;
use App\Http\Controllers\SInstitutionReportController;
use App\Http\Controllers\HBrandController;
use App\Http\Controllers\HDeviceTypeController;
use App\Http\Controllers\HHardwareController;
use App\Http\Controllers\FBeneficiaryController;
use App\Http\Controllers\FAccountController;
use App\Http\Controllers\FFluxController;
use App\Http\Controllers\FClasificationController;
use App\Http\Controllers\SCoordinatorController;
use App\Http\Controllers\SCoordinatorReportController;
use App\Http\Controllers\FFluxReportController;

// use App\Http\Controllers\SInstitutionReportController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware("auth")->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', ['title' => 'Inicio']);
    })->name("dashboard.index");

    Route::get('f_beneficiaries/getDataAutocomplete', [FBeneficiaryController::class, "getDataAutocomplete"])->name("f_beneficiaries.getDataAutocomplete");


    // Route::get('/refresh-emails', [EmailController::class, 'refreshEmails'])->name('emails.refresh');

    Route::middleware(['permission'])->group(function () {
        Route::resource('users', UserController::class);
        
        Route::get('users/{user}/changePassword', [UserController::class, 'changePassword'])->name('users.changePassword');
        Route::put('users/{user}/setNewPassword', [UserController::class, 'setNewPassword'])->name('users.setNewPassword');
        
        Route::resource('roles', RoleController::class);
        Route::resource('departaments', DepartamentController::class);

        Route::resource('expedients', ExpedientController::class);
        Route::get("exp_reports", [ExpReportController::class, "index"])->name("exp_reports.index");
        Route::resource('chk_checklists', ChkChecklistController::class);

        Route::resource('suppliers', SupplierController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('requisitions',RequisitionController::class);

        Route::get('s_sales', [SSaleController::class, "index"])->name("s_sales.index");
        Route::get('s_general_reports', [SGeneralReportController::class, "index"])->name("s_general_reports.index");
        Route::get('s_institucion_reports', [SInstitutionReportController::class, "index"])->name("s_institution_reports.index");
        Route::get('s_mensual_reports', [SMensualReportController::class, "index"])->name("s_mensual_reports.index");
        Route::get('s_coordinator_reports', [SCoordinatorReportController::class, "index"])->name("s_coordinator_reports.index");

        Route::resource('h_brands', HBrandController::class);
        Route::resource('h_device_types', HDeviceTypeController::class);
        Route::resource('h_hardwares', HHardwareController::class);
        Route::get('/h_haxrdwares/{h_hardware}/qr', [HHardwareController::class, 'generateQrCode'])->name('h_hardwares.qr');

        Route::put('f_fluxes/changeStats/{f_flux}', [FFluxController::class, 'changeStats'])->name('f_fluxes.changeStats');
        
        
        Route::get('f_flux_reports/exportAdminReport',  [FFluxReportController::class, 'exportAdminReport'])->name("f_flux_reports.exportAdminReport");
        Route::get('f_flux_reports',  [FFluxReportController::class, 'index'])->name("f_flux_reports.index");
        
        Route::resource('f_fluxes', FFluxController::class);
        Route::resource('f_accounts', FAccountController::class);
        Route::resource('f_beneficiaries', FBeneficiaryController::class);
        Route::resource('f_clasifications', FClasificationController::class);
        Route::resource('s_coordinators', SCoordinatorController::class);

        
    });


    Route::put("roles/savePermissions/{role}", [RoleController::class, "savePermissions"])->name("roles.savePermissions");
});



Route::get('/unauthorized', function () {
    return view('pages.unauthorized', ['title' => 'Usuario no autorizado']);
})->name("unauthorized");

        
