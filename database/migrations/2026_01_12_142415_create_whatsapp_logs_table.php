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
        Schema::create('whatsapp_logs', function (Blueprint $table) {
            $table->id();

            // Relación polimórfica (permiso, requisición, etc.)
            $table->nullableMorphs('related');

            // Datos del envío
            $table->string('to');
            $table->string('template_name');

            // Estado del envío
            $table->enum('status', [
                'PENDING',
                'SENT',
                'FAILED',
            ])->default('PENDING');

            // Respuesta de Meta
            $table->string('meta_message_id')->nullable();
            $table->text('error_message')->nullable();

            // Payload y respuesta completa
            $table->json('payload');
            $table->json('response')->nullable();

            // Fechas
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            // Índices útiles
            $table->index('status');
            $table->index('sent_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_logs');
    }
};
