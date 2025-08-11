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
        Schema::create('institution_commission_coordinators', function (Blueprint $table) {
             //Registra los casos expecionales en donde a un usuario se le da una comisión especial dependiendo de la institucion
            $table->bigIncrements(column: "id");
            $table->float("percentage");

            $table->unsignedSmallInteger('institution_id');
            $table->foreign('institution_id')->references('id')->on('institutions')->comment('Bono');
        
            $table->unsignedSmallInteger('coordinator_id');
            $table->foreign('coordinator_id')->references('id')->on('s_coordinators')->comment('Beneficiario');

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
        Schema::dropIfExists('institution_comission_coordinators');
    }
};
