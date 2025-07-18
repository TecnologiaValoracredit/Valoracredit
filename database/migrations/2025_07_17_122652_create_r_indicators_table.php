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
        Schema::create('r_indicators', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('institution_id')->nullable();
            $table->foreign('institution_id')->references('id')->on('institutions');

            $table->bigInteger('credit_id');
            $table->float('matching_captial');
            $table->float('total_portfolio')->nullable();
            $table->date('cut_date')->nullable();
            $table->date('portfolio_date')->nullable();
            $table->date('last_move_date')->nullable();

            $table->date('upload_date');

            $table->timestamps();
            $table->string('notes', 1024)->nullable()->comment('Notas');    
            $table->boolean('is_active')->default(1)->comment('Muestra si la fila está activa');
            $table->smallInteger('created_by')->unsigned()->nullable()->comment('Usuario que creó');
            $table->foreign('created_by')->references('id')->on('users');
            $table->smallInteger('updated_by')->unsigned()->nullable()->comment('Último usuario que modificó');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_indicators');
    }
};
