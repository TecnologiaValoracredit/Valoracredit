<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('s_sales', function (Blueprint $table) {
            $table->unsignedSmallInteger('s_credit_type_id')->default(1)->nullable();
            $table->foreign('s_credit_type_id')->references('id')->on('s_credit_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('s_sales', function (Blueprint $table) {
            $table->dropColumn('s_credit_type_id');
        });
    }
};
