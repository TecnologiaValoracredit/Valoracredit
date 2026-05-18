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
        Schema::create('vacation_dates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vacation_id');
            $table->foreign('vacation_id')->references('id')->on('vacations');

            $table->date('date');

            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacation_dates');
    }
};
