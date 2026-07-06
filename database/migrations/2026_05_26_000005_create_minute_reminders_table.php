<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('minute_reminders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedMediumInteger('minute_id');
            $table->foreign('minute_id')->references('id')->on('minutes')->cascadeOnDelete();

            $table->unsignedBigInteger('minute_task_id')->nullable();
            $table->foreign('minute_task_id')->references('id')->on('minute_tasks')->cascadeOnDelete();

            $table->string('channel', 20)->comment('email|telegram|whatsapp');
            $table->string('recipient', 191);
            $table->text('payload')->nullable();

            $table->timestamp('scheduled_at');
            $table->timestamp('sent_at')->nullable();
            $table->string('status', 20)->default('pending')->comment('pending|sent|failed');

            $table->timestamps();

            $table->index(['status', 'scheduled_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('minute_reminders');
    }
};
