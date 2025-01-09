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
        Schema::create('f_fluxes', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('f_account_id');
            $table->foreign('f_account_id')->references('id')->on('f_accounts');
            
            $table->date('accredit_date');

            $table->unsignedBigInteger('f_beneficiary_id');
            $table->foreign('f_beneficiary_id')->references('id')->on('f_beneficiaries');

            $table->string('concept');
            $table->float('amount');

            $table->unsignedSmallInteger('f_movement_type_id');
            $table->foreign('f_movement_type_id')->references('id')->on('f_movement_types');

            $table->string('account')->nullable();
            $table->string('account2')->nullable();
            $table->string('comments')->nullable();

            $table->unsignedSmallInteger('f_status_id');
            $table->foreign('f_status_id')->references('id')->on('f_statuses');

            
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
        Schema::dropIfExists('f_fluxes');
    }
};
