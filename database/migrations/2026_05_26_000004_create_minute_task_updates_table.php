<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('minute_task_updates', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('minute_task_id');
            $table->foreign('minute_task_id')->references('id')->on('minute_tasks')->cascadeOnDelete();

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('field', 60);
            $table->string('old_value', 1024)->nullable();
            $table->string('new_value', 1024)->nullable();

            $table->timestamps();

            $table->index('minute_task_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('minute_task_updates');
    }
};
