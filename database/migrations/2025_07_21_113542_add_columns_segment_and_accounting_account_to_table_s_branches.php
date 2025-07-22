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
        Schema::table('s_branches', function (Blueprint $table) {
            $table->string('segment')->nullable()->unique()->comment('Segmento de la sucursal');
            $table->string('accounting_account')->nullable()->unique()->comment('Cuenta contable de la sucursal');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('s_branches', function (Blueprint $table) {
            //
        });
    }
};
