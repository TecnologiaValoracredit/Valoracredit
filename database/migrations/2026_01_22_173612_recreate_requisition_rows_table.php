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
        Schema::create('requisition_rows', function(Blueprint $table){
            $table->id();

            $table->string('product');
            $table->string('product_description');

            $table->integer('product_quantity');
            $table->decimal('product_cost', 10, 2);

            $table->boolean('has_iva');

            $table->decimal('total_cost', 10, 2);

            $table->string('reason');
            $table->string('evidence')->nullable();
            $table->string('link')->nullable();

            $table->unsignedSmallInteger('currency_type_id');
            $table->foreign('currency_type_id')->references('id')->on('currency_types');

            $table->unsignedBigInteger('requisition_id');
            $table->foreign('requisition_id')->references('id')->on('requisitions');

            $table->unsignedSmallInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->string('notes')->nullable();

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
        Schema::dropIfExists('requisition_rows');
    }
};
