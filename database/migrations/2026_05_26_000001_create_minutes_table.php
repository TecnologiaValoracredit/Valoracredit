<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('minutes', function (Blueprint $table) {
            $table->mediumIncrements('id');

            $table->string('title');
            $table->date('meeting_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('notes')->nullable();

            $table->string('status', 30)->default('open')->comment('open|closed|canceled');

            $table->unsignedSmallInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();
            $table->boolean('is_active')->default(1)->comment('Muestra si la fila está activa');

            $table->index('meeting_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('minutes');
    }
};
