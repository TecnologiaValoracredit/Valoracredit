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
        Schema::create('permission_modules', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('description')->nullable();

            $table->unsignedTinyInteger('module_type_id')->nullable();
            $table->foreign('module_type_id')->references('id')->on('module_types'); 


            $table->unsignedBigInteger('parent_id')->nullable()->comment('Para submódulos, si es nulo es módulo principal, si no, pertenece a otro');
            $table->foreign('parent_id')->references('id')->on('permission_modules'); 

            $table->timestamps();

            // $table->string('notes', 1024)->nullable()->comment('Notas');    
            // $table->boolean('is_active')->default(1)->comment('Muestra si la fila está activa');
            // $table->smallInteger('created_by')->unsigned()->nullable()->comment('Usuario que creó');
            // $table->foreign('created_by')->references('id')->on('users');
            // $table->smallInteger('updated_by')->unsigned()->nullable()->comment('Último usuario que modificó');
            // $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_modules');
    }
};
