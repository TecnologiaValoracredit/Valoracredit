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
        Schema::table('s_coordinators', function (Blueprint $table) {
            $table->unsignedSmallInteger('manager_id')->nullable();
            $table->foreign('manager_id')->references('id')->on('s_managers')->comment('Datos del gerente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('s_coordinators', function (Blueprint $table) {
            //
        });
    }
};
