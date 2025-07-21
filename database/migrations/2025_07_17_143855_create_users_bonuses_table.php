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
        Schema::create('users_bonuses', function (Blueprint $table) {
            //Tabla intermedia entre usuarios y bonos, su objetivo es registrar que bonos tiene un empleado
            $table->smallIncrements(column: "id");
            $table->integer("bonus_percentage")->nullabel()->comment('Porcentaje de bono que se llevará');
            $table->integer("bonus_amount")->nullable()->comment('Porcentaje de bono que se llevará');
            
            $table->unsignedSmallInteger('bonus_id');
            $table->foreign('bonus_id')->references('id')->on('bonuses')->comment('Bono');
        
            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->comment('Beneficiario');

            $table->timestamps(); 
            $table->string('notes', 1024)->nullable()->comment('Notas');    
            $table->boolean('is_active')->default(1)->comment('Muestra si la fila está activa');
            $table->smallInteger('created_by')->unsigned()->nullable()->comment('Usuario que creó');
            $table->foreign('created_by')->references('id')->on('users');
            $table->smallInteger('updated_by')->unsigned()->nullable()->comment('Último usuario que modificó');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_bonuses');
    }
};
