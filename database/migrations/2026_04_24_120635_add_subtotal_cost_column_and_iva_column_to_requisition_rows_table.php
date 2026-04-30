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
            $table->decimal('subtotal_cost', 10, 2)->nullable();
            $table->decimal('iva', 10, 2)->nullable();
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
            $table->dropColumn([
                'subtotal_cost',
                'iva',
            ]);
        });
    }
};
