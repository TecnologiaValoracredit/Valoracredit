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
        Schema::create('vacation_policies', function (Blueprint $table) {
            $table->id();

            $table->unsignedTinyInteger('years_from');
            $table->unsignedTinyInteger('years_to');

            $table->unsignedTinyInteger('days');

            $table->unsignedTinyInteger('advance_days');
            $table->unsignedTinyInteger('applicable_month_range');

            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('vacation_policies');
    }
};
