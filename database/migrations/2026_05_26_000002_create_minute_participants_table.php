<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('minute_participants', function (Blueprint $table) {
            $table->mediumIncrements('id');

            $table->unsignedMediumInteger('minute_id');
            $table->foreign('minute_id')->references('id')->on('minutes')->cascadeOnDelete();

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('attendance_status', 30)->nullable()->comment('present|absent|excused');

            $table->timestamps();

            $table->unique(['minute_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('minute_participants');
    }
};
