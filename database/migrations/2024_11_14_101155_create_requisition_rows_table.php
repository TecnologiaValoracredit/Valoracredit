<?php

use App\Models\Requisition;
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
            $table->id();

            $table->unsignedBigInteger('requisition_id')->nullable();
            $table->foreign('requisition_id')->references('id')->on('requisitions');

            $table->smallInteger("amount");

            $table->unsignedSmallInteger("departament_id")->nullable();
            $table->foreign('departament_id')->references('id')->on('departaments');
            
            $table->unsignedSmallInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->string("description");
            $table->float("unit_price");
            $table->text("url")->nullable();

            $table->boolean("include_iva");
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
