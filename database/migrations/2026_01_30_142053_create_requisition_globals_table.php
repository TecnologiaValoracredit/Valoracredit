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
        Schema::create('requisition_globals', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->boolean('is_active');

            $table->date('application_date');

            $table->string('accounting_notes')->nullable()->comment('Notas de contabilidad');
            $table->string('administration_notes')->nullable()->comment('Notas de administración');

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
        Schema::dropIfExists('requisition_globals');
    }
};
