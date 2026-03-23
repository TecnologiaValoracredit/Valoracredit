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
        Schema::table('requisition_globals', function (Blueprint $table) {
            $table->unsignedTinyInteger('requisition_global_status_id')->nullable();
            $table->foreign('requisition_global_status_id')->references('id')->on('requisition_global_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisition_globals', function (Blueprint $table) {
            $table->dropForeign([
                'requisition_global_status_id',
            ]);

            $table->dropColumn([
                'requisition_global_status_id',
            ]);
        });
    }
};
