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
        Schema::create('permit_statuses', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->string('name');
            $table->string('description')->nullable();
            $table->string('color')->nullable();

            $table->timestamps();
            $table->string('notes')->nullable()->comment('Notas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permit_statuses');
    }
};
