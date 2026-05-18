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
        Schema::create('vacation_approvals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vacation_id');
            $table->foreign('vacation_id')->references('id')->on('vacations');

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->enum('decision', ['Aprobada', 'Rechazada']);

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
        Schema::dropIfExists('vacation_approvals');
    }
};
