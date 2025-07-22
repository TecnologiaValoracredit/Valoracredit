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
        Schema::create('commissions', function (Blueprint $table) {
            //Tabla en donde se lleva un registro de todas las comisiónes que se entregan cada día
            $table->smallIncrements(column: "id");

            $table->integer("total_sales")->comment('Cantidad de ventas que se hicieron');
            $table->integer("total_amount_sold")->comment('Cantidad de dinero que se vendió');
            $table->string("beneficiary_type")->comment('Tipo de beneficiario (Promotor, coordinador, broker)');
            $table->integer('amount_received')->comment('Importe entregado');
            $table->unsignedSmallInteger('s_sales_id');
            $table->foreign('s_sales_id')->references('id')->on('s_sales')->comment('Venta por la cual se generó la comisión');


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
        Schema::dropIfExists('commissions');
    }
};
