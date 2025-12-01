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
        Schema::create('user_contracts', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedSmallInteger('contract_id');
            $table->foreign('contract_id')->references('id')->on('contracts');

            $table->string('path_contract')->nullable();

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
        Schema::dropIfExists('user_contracts');
    }
};
