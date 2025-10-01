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
        Schema::table('s_sales', function (Blueprint $table) {
            
            $table->unsignedSmallInteger('s_manager_id')->nullable();
            $table->foreign('s_manager_id')->references('id')->on('s_managers')->comment('Gerente de suc');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_s_sales', function (Blueprint $table) {
            //
        });
    }
};
