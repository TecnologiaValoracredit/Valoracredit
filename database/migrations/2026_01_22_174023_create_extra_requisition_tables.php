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
        Schema::create('requisition_decisions', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->timestamps();
        });

        Schema::create('requisition_globals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('requisition_id');
            $table->foreign('requisition_id')->references('id')->on('requisitions');

            $table->timestamps();
        });

        Schema::create('requisition_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('requisition_id');
            $table->foreign('requisition_id')->references('id')->on('requisitions');

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');

            $table->string('action');

            $table->unsignedSmallInteger('from_status_id');
            $table->foreign('from_status_id')->references('id')->on('requisition_statuses');

            $table->unsignedSmallInteger('to_status_id');
            $table->foreign('to_status_id')->references('id')->on('requisition_statuses');

            $table->string('notes')->nullable();

            $table->timestamps();
        });

        Schema::create('requisition_approvals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('requisition_id');
            $table->foreign('requisition_id')->references('id')->on('requisitions');

            $table->unsignedSmallInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');

            $table->unsignedBigInteger('requisition_decision_id');
            $table->foreign('requisition_decision_id')->references('id')->on('requisition_decisions');

            $table->string('notes')->nullable();
            
            $table->timestamps();
        });

        Schema::create('requisition_entries', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('requisition_id');
            $table->foreign('requisition_id')->references('id')->on('requisitions');

            $table->string('poliza_number');

            $table->string('path_file');

            $table->string('notes')->nullable();

            $table->unsignedSmallInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();
        });
        
        Schema::create('requisition_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('requisition_id');
            $table->foreign('requisition_id')->references('id')->on('requisitions');

            $table->string('path_file');

            $table->unsignedSmallInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::create('requisition_month_registries', function(Blueprint $table){
            $table->id();

            $table->string('last_index');

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
        Schema::table('requisition_approvals', function (Blueprint $table) {
            $table->dropForeign(['requisition_decision_id']);
        });

        Schema::dropIfExists('requisition_decisions');
        Schema::dropIfExists('requisition_globals');
        Schema::dropIfExists('requisition_logs');
        Schema::dropIfExists('requisition_approvals');
        Schema::dropIfExists('requisition_entries');
        Schema::dropIfExists('requisition_payments');
        Schema::dropIfExists('requisition_month_registries');
    }
};
