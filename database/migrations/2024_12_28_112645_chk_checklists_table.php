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
     
            Schema::create('chck_checklist', function (Blueprint $table) {
      
                $table->id();
                $table->string('client_name');
                $table->date("date");
                $table->string('rfc');
                $table->bigInteger('credit_ammount');
                $table->bigInteger('dispersed_ammount');
                $table->smallInteger('credit_id');
                $table->bigInteger('sol_id');   // sol = solicitud
    
                $table->unsignedSmallInteger('chk_credit_type_id');  
                $table->foreign('chk_credit_type_id')->references('id')->on('chk_credit_types');
    
                $table->unsignedSmallInteger('exp_type_id');  
                $table->foreign('exp_type_id')->references('id')->on('exp_types');

                $table->unsignedSmallInteger('institution_id');
                $table->foreign('institution_id')->references('id')->on('institutions');
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    
    {

    }
};
    


