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
        Schema::create('permission_permissions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')->references('id')->on('permission_modules');

            $table->unsignedBigInteger('function_id');
            $table->foreign('function_id')->references('id')->on('permission_functions');

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
        Schema::dropIfExists('permission_permissions');
    }
};
