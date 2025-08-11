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
         // Modificar columnas
        Schema::table('institution_commissions', function (Blueprint $table) {
            // Eliminar llave foránea y columna user_id
            $table->dropForeign(['user_id']); // Elimina la restricción
            $table->dropColumn('user_id');   // Elimina la columna

            // Agregar nueva columna promotor_id con llave foránea
            $table->unsignedSmallInteger('promotor_id')->after('id'); 
            $table->foreign('promotor_id')->references('id')->on('s_promotors');
        });

        //Renombrar columna
        Schema::rename('institution_commissions', 'institution_commission_promotors');
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Renombrar tabla de vuelta
        Schema::rename('institution_commission_promotors', 'institution_commissions');

        // Primero revertimos columnas
        Schema::table('institution_commission_promotors', function (Blueprint $table) {
            // Eliminar nueva llave foránea y columna
            $table->dropForeign(['promotor_id']);
            $table->dropColumn('promotor_id');

            // Volver a agregar columna user_id
            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

       
    }
};
