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
        Schema::table('requisition_rows', function (Blueprint $table) {
            $table->unsignedSmallInteger('expense_duration_id')->nullable();
            $table->foreign('expense_duration_id')->references('id')->on('expense_durations');

            $table->date('starting_date')->nullable();
            $table->date('ending_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisition_rows', function (Blueprint $table) {
            $table->dropForeign([
                'expense_duration_id',
            ]);
            $table->dropColumn([
                'expense_duration_id',
                'starting_date',
                'ending_date',
            ]);
        });
    }
};
