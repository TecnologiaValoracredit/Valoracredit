<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('f_fluxes', function (Blueprint $table) {
            $table->unsignedSmallInteger('f_expense_type_id')->nullable();
            $table->foreign('f_expense_type_id')->references('id')->on('f_expense_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('f_fluxes', function (Blueprint $table) {
            $table->dropColumn('f_expense_type_id');
        });
    }
};
