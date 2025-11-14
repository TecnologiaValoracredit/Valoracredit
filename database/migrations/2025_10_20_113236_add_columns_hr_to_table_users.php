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
        Schema::table('users', function (Blueprint $table) {
            // $table->smallIncrements("id");
            // $table->string('name');
            // $table->string('email')->unique();

            // $table->unsignedBigInteger('role_id');
            // $table->foreign('role_id')->references('id')->on('roles');

            // $table->unsignedSmallInteger('departament_id');
            // $table->foreign('departament_id')->references('id')->on('departaments');

            // $table->unsignedSmallInteger('branch_id');
            // $table->foreign('branch_id')->references('id')->on('branches');

            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password')->nullable();
            // $table->rememberToken();
            // $table->timestamps();
            // $table->boolean("is_active")->default(true);

            $table->string('phone')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->date('birthday')->nullable();
            $table->date('entry_date')->nullable();
            $table->date('resignation_date')->nullable();

            $table->unsignedSmallInteger('position_id')->nullable();
            $table->foreign('position_id')->references('id')->on('job_positions');

            $table->decimal('salary', 10, 2)->nullable();
            $table->string('path_ine')->nullable();
            $table->string('path_curp')->nullable();
            $table->string('path_address')->nullable();
            $table->string('path_birth_document')->nullable();
            $table->string('path_account_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_users', function (Blueprint $table) {
            //
        });
    }
};
