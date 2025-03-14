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
            $table->string("tracking_key")->nullable()->comment("Clave de rastreo");

            $table->unsignedSmallInteger('f_cartera_status_id')->default(1)->nullable();
            $table->foreign('f_cartera_status_id')->references('id')->on('f_cartera_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('f_fluxes', function (Blueprint $table) {
            $table->dropColumn('tracking_key');
            $table->dropColumn('f_cartera_status_id');
        });
    }
};
