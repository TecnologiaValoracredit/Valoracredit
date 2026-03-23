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
        Schema::table('requisition_approvals', function (Blueprint $table) {
            $table->boolean('is_valid')->default(true);

            $table->unsignedBigInteger('requisition_global_id');
            $table->foreign('requisition_global_id')->references('id')->on('requisition_globals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisition_approvals', function (Blueprint $table) {
            $table->dropForeign([
                'requisition_global_id',
            ]);

            $table->dropColumn([
                'is_valid',
                'requisition_global_id',
            ]);
        });
    }
};
