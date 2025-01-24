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
        Schema::create('f_clasifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();

            $table->unsignedSmallInteger('f_movement_type_id')->nullable();
            $table->foreign('f_movement_type_id')->references('id')->on('f_movement_types');
            
            $table->unsignedBigInteger('parent_id')->nullable()->comment('Para submenús, si es nulo es menu principal, si no, es desplegable y no tiene funcion al hacer clic');
            $table->foreign('parent_id')->references('id')->on('f_clasifications'); 
    
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
        Schema::dropIfExists('f_clasifications');
    }
};
