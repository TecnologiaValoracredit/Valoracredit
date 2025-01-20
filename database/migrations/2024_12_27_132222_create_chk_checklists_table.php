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
        Schema::create('chk_checklists', function (Blueprint $table) {
      
            $table->id();
            $table->string('client_name');
            $table->date("date");
            $table->string('rfc');
            $table->bigInteger('credit_ammount');
            $table->bigInteger('dispersed_ammount');  
            $table->integer('credit_id')->default(1);
            $table->integer('sol_id')->default(1);
            $table->unsignedSmallInteger('chk_credit_type_id')->nullable();;
            $table->foreign('chk_credit_type_id')->references('id')->on('chk_credit_types');

            $table->unsignedSmallInteger('exp_type_id')->nullable();;  
            $table->foreign('exp_type_id')->references('id')->on('exp_types');

            $table->unsignedSmallInteger('institution_id')->nullable();
            $table->foreign('institution_id')->references('id')->on('institutions');
            
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
        //
    }
};
