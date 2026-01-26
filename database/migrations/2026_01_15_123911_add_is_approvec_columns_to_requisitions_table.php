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
            $table->boolean('is_approved_by_boss')->nullable()->comment('Muestra si la requisición fue aprobada por el jefe inmediato');
            $table->boolean('is_approved_by_admin')->nullable()->comment('Muestra si la requisición fue aprobada por administración');
            $table->boolean('is_approved_by_chief')->nullable()->comment('Muestra si la requisición fue aprobada por dirección general');
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
            $table->dropColumn([
                'is_approved_by_boss',
                'is_approved_by_admin',
                'is_approved_by_chief',
            ]);
        });
    }
};
