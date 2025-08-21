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
            $table->bigIncrements( "id");

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->comment('Usuario que pidió la requisición');
        
            $table->unsignedSmallInteger('requisition_status_id');
            $table->foreign('requisition_status_id')->references('id')->on('requisition_statuses')->comment('Estatus actual de la requisición');

            $table->unsignedSmallInteger('payment_type_id');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->comment('Forma de pago de la requisicion');

            $table->unsignedSmallInteger('departament_id');
            $table->foreign('departament_id')->references('id')->on('departaments')->comment('Departamento beneficiario de la requisición');

            $table->unsignedSmallInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->comment('Sucursal a la cual pertenece la requisición');

            $table->unsignedSmallInteger('approval_boss_id');
            $table->foreign('approval_boss_id')->references('id')->on('users')->comment('jefe directo del solicitante');
            $table->timestamp(  "boss_approval_date")->nullable();

            $table->unsignedSmallInteger('approval_admin_id');
            $table->foreign('approval_admin_id')->references('id')->on('users')->comment('administración');
            $table->timestamp( "admin_approval_date")->nullable();

            $table->unsignedSmallInteger('approval_chief_id');
            $table->foreign('approval_chief_id')->references('id')->on('users')->comment('director general');
            $table->timestamp( "chief_approval_date")->nullable();

            $table->float('amount', 10, 2)->default(0)->nullable();
            $table->timestamp( "request_date")->nullable();

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
