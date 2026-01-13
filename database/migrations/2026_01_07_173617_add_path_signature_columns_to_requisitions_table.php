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
            $table->string('path_user_signature')->nullable();
            $table->string('path_boss_signature')->nullable();
            $table->string('path_admin_signature')->nullable();
            $table->string('path_chief_signature')->nullable();
            $table->boolean('is_urgent')->default(0);
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
                'path_user_signature',
                'path_boss_signature',
                'path_admin_signature',
                'path_chief_signature',
                'is_urgent',
            ]);
        });
    }
};
