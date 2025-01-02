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
        Schema::create('email_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('host');
            $table->integer('port');
            $table->string('encryption')->nullable(); // 'ssl', 'none', etc.
            $table->boolean('validate_cert')->default(true);
            $table->string('username');
            $table->string('password');
            $table->string('protocol')->default('pop3'); // 'imap' o 'pop3'
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
        Schema::dropIfExists('email_accounts');
    }
};
