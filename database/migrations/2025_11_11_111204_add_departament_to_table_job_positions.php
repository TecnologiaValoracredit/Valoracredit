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
        Schema::table('job_positions', function (Blueprint $table) {
            //Add departament column on job positions table, referencing an ID from departaments table.
            $table->unsignedSmallInteger('departament_id')->nullable();
            $table->foreign('departament_id')->references('id')->on('departaments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_positions', function (Blueprint $table) {
            //Drop foreign key departament column and departament column

            $table->dropForeign(['departament_id']);
            $table->dropColumn('departament_id');
        });
    }
};
