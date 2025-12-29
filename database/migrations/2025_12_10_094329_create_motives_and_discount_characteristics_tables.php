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
        Schema::create('motives', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->string('name');
            $table->string('description')->nullable();
            
            $table->timestamps();
            $table->string('notes', 1024)->nullable()->comment('Notas');
        });

        Schema::create('discount_characteristics', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->string('name');
            $table->string('description')->nullable();
            
            $table->timestamps();
            $table->string('notes', 1024)->nullable()->comment('Notas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motives');
        Schema::dropIfExists('discount_characteristics');
    }
};
