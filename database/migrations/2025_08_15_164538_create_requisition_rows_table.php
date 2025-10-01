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
        Schema::create('requisition_rows', function (Blueprint $table) {
            $table->bigIncrements(column: "id");
            $table->string("product")->comment("Producto");
            $table->string("product_description")->nullable();
            $table->integer("product_quantity")->comment("Cantidad a pedir del producto");
            $table->float('product_cost', 10, 2)->comment("Precio unitario del producto");    
            $table->boolean("has_iva")->comment("¿El precio incluye IVA?");
            $table->float('total_cost', 10, 2)->comment("Costo total");
            $table->string("reason")->nullable()->comment("Razón de la elección");
            $table->string("evidence")->comment("Evidencia del producto");
            $table->string("link")->comment("Link del producto");

            $table->unsignedSmallInteger('currency_type_id')->nullable();
            $table->foreign('currency_type_id')->references('id')->on('currency_types')->comment('Tipo de moneda del precio');

            $table->unsignedBigInteger('requisition_id');
            $table->foreign('requisition_id')->references('id')->on('requisitions')->comment('Requisición a la que pretenece');
        
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('requisition_rows')->comment('Requisition row a la que pertenece');

            $table->unsignedSmallInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->comment('Proveedor del producto');

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
        Schema::dropIfExists('requisition_rows');
    }
};
