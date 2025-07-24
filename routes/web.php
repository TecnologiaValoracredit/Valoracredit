<?php

use App\Http\Controllers\PreApplicationController;
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
use App\Http\Controllers\RequisitionRowOptionalController;
use App\Http\Controllers\ChkChecklistController;
use App\Http\Controllers\SSaleController;
use App\Http\Controllers\SGeneralReportController;
use App\Http\Controllers\SMensualReportController;
use App\Http\Controllers\SInstitutionReportController;
use App\Http\Controllers\SBranchController;
use App\Http\Controllers\HBrandController;
use App\Http\Controllers\HDeviceTypeController;
use App\Http\Controllers\HHardwareController;
use App\Http\Controllers\FBeneficiaryController;
use App\Http\Controllers\FAccountController;
use App\Http\Controllers\FFluxController;
use App\Http\Controllers\FClasificationController;
use App\Http\Controllers\SCoordinatorController;
use App\Http\Controllers\SPromotorController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\SCoordinatorReportController;
use App\Http\Controllers\FFluxReportController;
use App\Http\Controllers\SPromotorReportController;
use App\Http\Controllers\RIndicatorController;
//Commissions 
use App\Http\Controllers\ComCoordinatorController;
use App\Http\Controllers\ComPromotorController;

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

    Route::get('f_clasifications/getDataAutocomplete/{f_movement_type}', [FClasificationController::class, "getDataAutocomplete"])->name("f_clasifications.getDataAutocomplete");
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
        Route::delete('/requisition_row_optionals/{id}', [RequisitionRowOptionalController::class, 'destroy'])
        ->name('requisition_row_optionals.destroy');

        // Route::resource('s_sales', SSaleController::class);

        Route::get('s_sales', [SSaleController::class, "index"])->name("s_sales.index");
        Route::get('s_general_reports', [SGeneralReportController::class, "index"])->name("s_general_reports.index");
        Route::get('s_institucion_reports', [SInstitutionReportController::class, "index"])->name("s_institution_reports.index");
        Route::get('s_mensual_reports', [SMensualReportController::class, "index"])->name("s_mensual_reports.index");
        Route::get('s_coordinator_reports', [SCoordinatorReportController::class, "index"])->name("s_coordinator_reports.index");
        Route::get('s_promotor_reports', [SPromotorReportController::class, "index"])->name("s_promotor_reports.index");
        Route::get('r_indicators', [RIndicatorController::class, "index"])->name("r_indicators.index");
        Route::resource('s_branches', SBranchController::class);

        Route::resource('h_brands', HBrandController::class);
        Route::resource('h_device_types', HDeviceTypeController::class);
        Route::resource('h_hardwares', HHardwareController::class);
        Route::get('/h_hardwares/{h_hardware}/generateQrCode', [HHardwareController::class, 'generateQrCode'])->name('h_hardwares.generateQrCode');

        Route::put('f_fluxes/changeStats/{f_flux}', [FFluxController::class, 'changeStats'])->name('f_fluxes.changeStats');
        Route::put('f_fluxes/changeCarteraStatus/{f_flux}', [FFluxController::class, 'changeCarteraStatus'])->name('f_fluxes.changeCarteraStatus');
        
        Route::post('f_fluxes/storeFromExcel',  [FFluxController::class, 'storeFromExcel'])->name("f_fluxes.storeFromExcel");
        Route::get('f_fluxes/createFromExcel',  [FFluxController::class, 'createFromExcel'])->name("f_fluxes.createFromExcel");
        Route::post('f_fluxes/importExcel',  [FFluxController::class, 'importExcel'])->name("f_fluxes.importExcel");

        Route::get('f_flux_reports/exportAdminReport',  [FFluxReportController::class, 'exportAdminReport'])->name("f_flux_reports.exportAdminReport");
        Route::get('f_flux_reports/exportFluxReport',  [FFluxReportController::class, 'exportFluxReport'])->name("f_flux_reports.exportFluxReport");
        Route::get('f_flux_reports',  [FFluxReportController::class, 'index'])->name("f_flux_reports.index");
        
        Route::resource('f_fluxes', FFluxController::class);
        Route::resource('f_accounts', FAccountController::class);

        Route::get('f_beneficiaries/getAddModal', [FBeneficiaryController::class, 'getAddModal'])->name("f_beneficiaries.getAddModal");
        Route::resource('f_beneficiaries', FBeneficiaryController::class);
        Route::resource('f_clasifications', FClasificationController::class);
        Route::resource('s_coordinators', SCoordinatorController::class);
        
        //Commissions 
        Route::resource('s_coordinators', SCoordinatorController::class);
        Route::resource('s_promotors', SPromotorController::class);
        Route::resource('commissions', CommissionController::class);

    });
    Route::put("roles/savePermissions/{role}", [RoleController::class, "savePermissions"])->name("roles.savePermissions");
    Route::get('s_promotor_reports/getTable/{year}', [SPromotorReportController::class, "getTable"])->name("s_promotor_reports.getTable");

    //DATATABLES
    Route::get('r_indicators/getRIndicatorFinalDataTable',  [RIndicatorController::class, 'getRIndicatorFinalDataTable'])->name('r_indicators.getRIndicatorFinalDataTable');
    Route::get('r_indicators/getRIndicatorDataTable',  [RIndicatorController::class, 'getRIndicatorDataTable'])->name('r_indicators.getRIndicatorDataTable');

   
});
Route::get('pre_applications',  [PreApplicationController::class, 'index'])->name("pre_applications.index");
Route::get('pre_applications_calculator',  [PreApplicationController::class, 'index'])->name("pre_applications_calculator.index");
Route::post('s_sales/import_excel', [SSaleController::class, "importExcel"])->name("s_sales.importExcel");
Route::post('expedient/import_excel', [ExpedientController::class, "importExcel"])->name("expedients.importExcel");

    Route::delete('commissions/deleteInstitution/{institution_commission}',  [CommissionController::class, 'deleteInstitution'])->name('commissions.deleteInstitution');
    Route::delete('commissions/deleteName/{s_user_name}',  [CommissionController::class, 'deleteName'])->name('commissions.deleteName');
Route::get('commissions/export_report',  [CommissionController::class, 'exportReport'])->name("commissions.exportReport");

 //Comisiones - coordinadores y promotores
    Route::get('commissions/getInstitutionCommissionDataTable/{user}',  [CommissionController::class, 'getInstitutionCommissionDataTable'])->name('commissions.getInstitutionCommissionDataTable');
    Route::get('commissions/getSUserNameDataTable/{user}',  [CommissionController::class, 'getSUserNameDataTable'])->name('commissions.getSUserNameDataTable');

    Route::post('commissions/addInstitution/{user}',  [CommissionController::class, 'addInstitution'])->name('commissions.addInstitution');
    Route::post('commissions/addName/{user}',  [CommissionController::class, 'addName'])->name('commissions.addName');

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/unauthorized', function () {
    return view('pages.unauthorized', ['title' => 'Usuario no autorizado']);
})->name("unauthorized");

