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
        Schema::create('expedients', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("credit_id");
            $table->string('client_name');
            $table->date("opening_date");
            $table->float("credit_amount");
            $table->float("pay");
            $table->date("portafolio_date");

            $table->unsignedSmallInteger('institution_id')->nullable();
            $table->foreign('institution_id')->references('id')->on('institutions');

            $table->unsignedSmallInteger('anchorer_id')->nullable();
            $table->foreign('anchorer_id')->references('id')->on('anchorers');

            $table->unsignedSmallInteger('exp_status_id')->nullable();
            $table->foreign('exp_status_id')->references('id')->on('exp_statuses');

            $table->unsignedSmallInteger('ubi_status_id')->nullable();
            $table->foreign('ubi_status_id')->references('id')->on('ubi_statuses');

            $table->unsignedSmallInteger('ubication_id')->nullable();
            $table->foreign('ubication_id')->references('id')->on('ubications');

            $table->unsignedSmallInteger('exp_type_id')->nullable();
            $table->foreign('exp_type_id')->references('id')->on('exp_types');

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
        Schema::dropIfExists('expedients');
    }
};
