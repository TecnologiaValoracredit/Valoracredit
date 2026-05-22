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
        Schema::create('vacation_balances', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedTinyInteger('active_years');

            $table->unsignedTinyInteger('days_assigned');
            $table->unsignedTinyInteger('days_used');
            $table->unsignedTinyInteger('days_remaining');
            $table->unsignedTinyInteger('advance_days_available');
            $table->unsignedTinyInteger('advance_days_used');

            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('vacation_balances');
    }
};
