<?php

use App\Models\PermissionModule;
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
        Schema::table('permission_modules', function (Blueprint $table) {
            //

            PermissionModule::create([
                'name' => 'contracts',
                'description' => 'Contratos',
                'module_type_id' => '2',
                'parent_id' => '2'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_modules', function (Blueprint $table) {
            //
            PermissionModule::where('name', 'contracts')->delete();
        });
    }
};
