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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedSmallInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('email_account_id')->nullable();
            $table->foreign('email_account_id')->references('id')->on('email_accounts');

            $table->string('message_id')->unique();
            $table->string('subject')->nullable();
            $table->string('from');
            $table->text('body')->nullable();
            $table->timestamp('date')->nullable();
            $table->boolean('is_read')->default(false);
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
        Schema::dropIfExists('emails');
    }
};
