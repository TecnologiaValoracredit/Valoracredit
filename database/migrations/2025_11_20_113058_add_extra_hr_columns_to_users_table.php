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
            $table->string('extension')->nullable();
            
            $table->string('path_rfc')->nullable();
            $table->string('path_nss')->nullable();

            $table->string('curp')->nullable();
            $table->string('rfc')->nullable();
            $table->string('nss')->nullable();

            $table->unsignedSmallInteger('employee_number')->nullable();

            $table->string('birthplace')->nullable();
            
            $table->unsignedSmallInteger('gender_id')->nullable();
            $table->foreign('gender_id')->references('id')->on('genders');

            $table->unsignedSmallInteger('civil_status_id')->nullable();
            $table->foreign('civil_status_id')->references('id')->on('civil_statuses');


            $table->string('residential_address')->nullable();
            $table->string('colony')->nullable();
            $table->string('municipality')->nullable();
            $table->string('postal_code')->nullable();

            $table->string('other_benefits')->nullable();
            $table->string('interbank_code')->nullable();
            $table->string('plastic_number')->nullable();
            $table->string('infonavit_credit_number')->nullable();
            $table->unsignedTinyInteger('discount_factor')->nullable();
            $table->string('fonacot_credit_number')->nullable();
            $table->string('food_pension')->nullable();

            $table->date('termination_date')->nullable();

            $table->unsignedSmallInteger('termination_reason_id')->nullable();
            $table->foreign('termination_reason_id')->references('id')->on('termination_reasons');

            $table->string('termination_description')->nullable();

            $table->boolean('is_replacing_on_hired')->nullable();
            
            $table->unsignedSmallInteger('replacement_for_id')->nullable()->comment('En caso de ser contratado como reemplazo, se referencia al id del usuario a reemplazar');
            $table->foreign('replacement_for_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
public function down()
{
    Schema::table('users', function (Blueprint $table) {

        $table->dropForeign(['termination_reason_id']);
        $table->dropForeign(['replacement_for_id']);
        $table->dropForeign(['gender_id']);
        $table->dropForeign(['civil_status_id']);

        $table->dropColumn([
            'extension',
            'path_rfc',
            'path_nss',
            'curp',
            'rfc',
            'nss',
            'employee_number',
            'birthplace',
            'gender_id',
            'civil_status_id',
            'residential_address',
            'colony',
            'municipality',
            'postal_code',
            'other_benefits',
            'interbank_code',
            'plastic_number',
            'infonavit_credit_number',
            'discount_factor',
            'fonacot_credit_number',
            'food_pension',
            'termination_date',
            'termination_reason_id',
            'termination_description',
            'is_replacing_on_hired',
            'replacement_for_id',
        ]);
    });
}
};
