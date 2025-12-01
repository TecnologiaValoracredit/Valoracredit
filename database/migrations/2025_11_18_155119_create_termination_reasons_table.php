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
        Schema::create('termination_reasons', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->string('name');
            $table->string('description')->nullable();

            $table->unsignedSmallInteger('parent_id')->nullable()->comment('Para sub-razones, si es nulo es una razon principal, si no pertenece a otra');
            $table->foreign('parent_id')->references('id')->on('termination_reasons');

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
        Schema::dropIfExists('termination_reasons');
    }
};
