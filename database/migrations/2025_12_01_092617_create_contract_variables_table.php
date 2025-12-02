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
        Schema::create('contract_variables', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->string('name');              // Nombre legible
            $table->string('key_detection');     // Ej: {{CURP}}

            $table->string('type')->default('column');
            // 'column' → se obtiene de una columna
            // 'relation' → viene de una relación
            // 'custom' → variable calculada

            // Para type = 'column'
            $table->string('model')->nullable();        // App\Models\User
            $table->string('model_column')->nullable(); // curp

            // Para type = 'relation'
            $table->string('relation_name')->nullable(); // Ej: department
            $table->string('relation_column')->nullable(); // Ej: name

            // Para type = 'custom'
            $table->string('handler')->nullable();
            // Ej handler = App\ContractVariables\FechaEnLetras

            $table->string('description')->nullable();

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
        Schema::dropIfExists('contract_variables');
    }
};
