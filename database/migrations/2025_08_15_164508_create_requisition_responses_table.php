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
        Schema::create('requisition_responses', function (Blueprint $table) {
             $table->bigIncrements(column: "id");

            $table->unsignedSmallInteger('requisition_status_id');
            $table->foreign('requisition_status_id')->references('id')->on('requisition_statuses')->comment('Estatus que se le asignó');

            $table->string("reason")->nullable()->comment("Razón por la que se le asignó el estatus");

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->comment('Usuario que revisó la requisición');

            $table->unsignedBigInteger('requisition_id');
            $table->foreign('requisition_id')->references('id')->on('requisitions')->comment('Requisición que se revisó');

            
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
        Schema::dropIfExists('requisition_responses');
    }
};
