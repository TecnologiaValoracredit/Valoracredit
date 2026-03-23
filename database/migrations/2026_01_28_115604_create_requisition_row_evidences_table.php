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
        Schema::create('requisition_row_evidences', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('requisition_row_id');
            $table->foreign('requisition_row_id')->references('id')->on('requisition_rows');

            $table->string('path');

            $table->boolean('is_active')->default(1);

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
        Schema::dropIfExists('requisition_row_evidences');
    }
};
