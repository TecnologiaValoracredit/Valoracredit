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
        Schema::create('h_hardwares', function (Blueprint $table) {
            
            $table->smallIncrements('id');
            $table->string('name')->nullable();

            $table->unsignedSmallInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedSmallInteger('h_device_type_id')->nullable();
            $table->foreign('h_device_type_id')->references('id')->on('h_device_types');

            $table->unsignedSmallInteger('h_brand_id')->nullable();
            $table->foreign('h_brand_id')->references('id')->on('h_brands');

            $table->unsignedSmallInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches');

            $table->unsignedSmallInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');

            $table->string('serial_number')->nullable();
            $table->string('custom_serial_number');
            $table->string('color');
            $table->string('specifications')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('image')->nullable();

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
        Schema::dropIfExists('h_hardwares');
    }
};
