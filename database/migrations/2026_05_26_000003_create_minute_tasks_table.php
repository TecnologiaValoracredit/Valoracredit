<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('minute_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedMediumInteger('minute_id');
            $table->foreign('minute_id')->references('id')->on('minutes')->cascadeOnDelete();

            $table->unsignedBigInteger('parent_task_id')->nullable();
            $table->foreign('parent_task_id')->references('id')->on('minute_tasks')->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->unsignedSmallInteger('assigned_to')->nullable();
            $table->foreign('assigned_to')->references('id')->on('users');

            $table->string('status', 20)->default('pending')->comment('pending|in_progress|completed|canceled');
            $table->string('priority', 10)->default('medium')->comment('low|medium|high|urgent');

            $table->date('due_date')->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->text('comments')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->unsignedSmallInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->unsignedInteger('position')->nullable();

            $table->timestamps();

            $table->index(['minute_id', 'status']);
            $table->index('assigned_to');
        });
    }

    public function down()
    {
        Schema::dropIfExists('minute_tasks');
    }
};
