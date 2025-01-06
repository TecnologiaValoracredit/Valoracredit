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

    // Route::get('/refresh-emails', [EmailController::class, 'refreshEmails'])->name('emails.refresh');

    Route::middleware(['permission'])->group(function () {
        Route::resource('users', UserController::class);
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

    });
    Route::put("roles/savePermissions/{role}", [RoleController::class, "savePermissions"])->name("roles.savePermissions");
});


Route::get('/unauthorized', function () {
    return view('pages.page.unauthorized', ['title' => 'Usuario no autorizado']);
})->name("unauthorized");
