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
        Schema::create('permits', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedSmallInteger('departament_id');
            $table->foreign('departament_id')->references('id')->on('departaments');

            $table->unsignedSmallInteger('job_position_id');
            $table->foreign('job_position_id')->references('id')->on('job_positions');

            $table->unsignedSmallInteger('boss_id')->nullable();
            $table->foreign('boss_id')->references('id')->on('users');

            $table->unsignedSmallInteger('hr_id')->nullable();
            $table->foreign('hr_id')->references('id')->on('users');

            $table->date('permit_date');

            $table->dateTime('entry_hour');
            $table->dateTime('exit_hour');
            
            $table->decimal('pending_hours');

            $table->unsignedSmallInteger('motive_id');
            $table->foreign('motive_id')->references('id')->on('motives');

            $table->unsignedSmallInteger('discount_characteristic_id');
            $table->foreign('discount_characteristic_id')->references('id')->on('discount_characteristics');

            $table->string('user_observations')->nullable();
            $table->string('boss_observations')->nullable();
            $table->string('hr_observations')->nullable();

            $table->boolean('is_signed_by_hr')->nullable();
            $table->boolean('is_signed_by_boss')->nullable();

            $table->string('path_user_signature')->nullable();
            $table->string('path_hr_signature')->nullable();
            $table->string('path_boss_signature')->nullable();

            $table->unsignedSmallInteger('permit_status_id')->default(1); //Al crear un permiso setea en automatico el status de creado
            $table->foreign('permit_status_id')->references('id')->on('permit_statuses');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permits');
    }
};
