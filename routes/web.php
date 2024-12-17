<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\ExpedientController;
use App\Http\Controllers\ExpReportController;

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

    Route::middleware(['permission'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('departaments', DepartamentController::class);

        Route::resource('expedients', ExpedientController::class);
        Route::get("exp_reports", [ExpReportController::class, "index"])->name("exp_reports.index");

    });
    Route::put("roles/savePermissions/{role}", [RoleController::class, "savePermissions"])->name("roles.savePermissions");
});


Route::get('/unauthorized', function () {
    return view('pages.page.unauthorized', ['title' => 'Usuario no autorizado']);
})->name("unauthorized");
