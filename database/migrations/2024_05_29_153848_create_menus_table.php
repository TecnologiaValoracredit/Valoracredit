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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('icon')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable()->comment('Para submenús, si es nulo es menu principal, si no, es desplegable y no tiene funcion al hacer clic');
            $table->foreign('parent_id')->references('id')->on('menus'); 

            $table->float('position');

            $table->unsignedBigInteger('permission_id')->nullable()->comment('permissions');
            $table->foreign('permission_id')->references('id')->on('permission_permissions'); 

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
        Schema::dropIfExists('menus');
    }
};
