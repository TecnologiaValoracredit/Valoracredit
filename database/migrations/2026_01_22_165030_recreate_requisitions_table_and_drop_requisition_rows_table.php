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
        Schema::table('requisition_rows', function(Blueprint $table){
            $table->dropForeign(['requisition_id']);
            $table->dropForeign(['currency_type_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('requisition_rows');
        Schema::dropIfExists('requisitions');

        Schema::create('requisitions', function(Blueprint $table){
            $table->id();

            $table->string('folio');
            
            $table->unsignedSmallInteger('request_id');
            $table->foreign('request_id')->references('id')->on('users');

            $table->unsignedSmallInteger('boss_id');
            $table->foreign('boss_id')->references('id')->on('users');
            
            $table->unsignedSmallInteger('current_status_id');
            $table->foreign('current_status_id')->references('id')->on('requisition_statuses');
            
            $table->string('current_owner_permission')->nullable();
            
            $table->unsignedSmallInteger('payment_type_id');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            
            $table->unsignedBigInteger('amount');
            
            $table->dateTime('request_date');
            
            $table->unsignedSmallInteger('departament_id');
            $table->foreign('departament_id')->references('id')->on('departaments');
            
            $table->unsignedSmallInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches');
            
            $table->unsignedSmallInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->unsignedSmallInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->dateTime('cancelled_at')->nullable();

            $table->unsignedSmallInteger('cancelled_by')->nullable();
            $table->foreign('cancelled_by')->references('id')->on('users');

            $table->boolean('is_urgent')->default(false);

            $table->string('notes')->nullable();

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
        Schema::dropIfExists('requisition_rows');
        Schema::dropIfExists('requisitions');
    }
};
