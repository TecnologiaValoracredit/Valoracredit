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
        Schema::table('requisitions', function (Blueprint $table) {
            $table->unsignedSmallInteger('expense_type_id')->nullable();
            $table->foreign('expense_type_id')->references('id')->on('expense_types');

            $table->boolean('is_fixed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->dropForeign([
                'expense_type_id',
            ]);

            $table->dropColumn([
                'expense_type_id',
                'is_fixed',
            ]);
        });
    }
};
