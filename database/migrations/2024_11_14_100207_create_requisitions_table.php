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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('user_id')->nullable(); 
            $table->foreign('user_id')->references('id')->on('users'); 

            $table->unsignedSmallInteger('requisition_status_id')->nullable();
            $table->foreign('requisition_status_id')->references('id')->on('requisition_statuses');

            $table->unsignedSmallInteger('payment_type_id')->nullable();
            $table->foreign('payment_type_id')->references('id')->on('payment_types');

            $table->unsignedSmallInteger('departament_id')->nullable();
            $table->foreign('departament_id')->references('id')->on('departaments');

            $table->unsignedSmallInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches');

            $table->date("application_date"); 

            $table->smallInteger('inmediate_boss_user_id')->unsigned()->nullable()->comment('Jefe inmediato que le pertenece esta requisición');
            $table->foreign('inmediate_boss_user_id')->references('id')->on('users');

            $table->smallInteger('administration_user_id')->unsigned()->nullable()->comment('Administración que le pertenece esta requisición');
            $table->foreign('administration_user_id')->references('id')->on('users');

            $table->smallInteger('general_direction_user_id')->unsigned()->nullable()->comment('Dirección general que le pertenece esta requisición');
            $table->foreign('general_direction_user_id')->references('id')->on('users');

            $table->boolean("is_approved_inmediante_boss")->default(0);
            $table->boolean("is_approved_administration")->default(0);
            $table->boolean("is_approved_general_direction")->default(0);

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
        Schema::dropIfExists('requisitions');
    }
};
