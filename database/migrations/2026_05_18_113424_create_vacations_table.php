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
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedSmallInteger('boss_id');
            $table->foreign('boss_id')->references('id')->on('users');

            $table->tinyInteger('total_days');
            
            $table->string('reason')->nullable();
            
            $table->unsignedTinyInteger('vacation_status_id');
            $table->foreign('vacation_status_id')->references('id')->on('vacation_statuses');
            
            $table->tinyInteger('days_available_before');
            $table->tinyInteger('days_available_after');

            $table->unsignedSmallInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            
            $table->unsignedSmallInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->timestamps();

            $table->string('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacations');
    }
};
