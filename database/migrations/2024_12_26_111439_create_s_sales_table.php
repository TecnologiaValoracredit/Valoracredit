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
        Schema::create('s_sales', function(Blueprint $table)
        {
            $table->id();
            $table->bigInteger('credit_id');
            $table->string('client_name');
            $table->float('credit_amount');
            $table->date('grant_date');

            $table->unsignedSmallInteger('institution_id');
            $table->foreign('institution_id')->references('id')->on('institutions');

            $table->unsignedSmallInteger('s_branch_id');
            $table->foreign('s_branch_id')->references('id')->on('s_branches');

            $table->unsignedSmallInteger('s_coordinator_id');
            $table->foreign('s_coordinator_id')->references('id')->on('s_coordinators');

            $table->unsignedSmallInteger('s_status_id');
            $table->foreign('s_status_id')->references('id')->on('s_statuses');
            
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
        Schema::dropIfExists('s_sales');
    }
};
