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
        Schema::dropIfExists('requisition_logs');
        Schema::dropIfExists('requisition_rows');
        Schema::dropIfExists('requisition_row_optionals');
        Schema::dropIfExists('requisitions');
        Schema::dropIfExists('requisition_statuses');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
