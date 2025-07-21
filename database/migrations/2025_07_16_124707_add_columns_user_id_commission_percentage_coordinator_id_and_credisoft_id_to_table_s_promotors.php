<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('s_promotors', function (Blueprint $table) {
            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->comment('Datos del empleado');

            $table->integer('commission_percentage')->comment('Porcentaje de comisión que se tiene por default');

            $table->unsignedSmallInteger('coordinator_id');
            $table->foreign('coordinator_id')->references('id')->on('s_coordinators')->comment('Coordinador del promotor');

            $table->unsignedSmallInteger('s_branch_id');
            $table->foreign('s_branch_id')->references('id')->on('s_branches')->comment('Sucursal a la cual pertenece (Dentro del sistema CrediSoft)');

            $table->unsignedSmallInteger('promotor_credisoft_id')->comment('Id que tiene el promotor dentro del sistema CrediSoft');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('s_promotors', function (Blueprint $table) {
            //
        });
    }
};
