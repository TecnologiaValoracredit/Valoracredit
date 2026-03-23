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
        Schema::create('requisition_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('requisition_id');
            $table->foreign('requisition_id')->references('id')->on('requisitions');

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');

            $table->string('action')->nullable();

            $table->unsignedSmallInteger('from_status_id')->nullable();
            $table->foreign('from_status_id')->references('id')->on('requisition_statuses');

            $table->unsignedSmallInteger('to_status_id');
            $table->foreign('to_status_id')->references('id')->on('requisition_statuses');

            $table->string('notes')->nullable();

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
        Schema::dropIfExists('requisition_logs');
    }
};
