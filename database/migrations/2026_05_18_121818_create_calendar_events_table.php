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
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();

            $table->string('event_type');
            $table->string('title');
            $table->string('description');

            $table->date('start_date');
            $table->date('end_date');

            $table->boolean('all_day');
            $table->string('color');

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->morphs('related');

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
        Schema::dropIfExists('calendar_events');
    }
};
