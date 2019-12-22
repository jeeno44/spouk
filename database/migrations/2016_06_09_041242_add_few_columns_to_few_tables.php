<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFewColumnsToFewTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('specializations_groups', function (Blueprint $blueprint) {
            $blueprint->dropColumn('kcp');
            $blueprint->integer('free_places');
            $blueprint->integer('non_free_places');
        });
        Schema::table('specializations', function (Blueprint $blueprint) {
            $blueprint->integer('kcp');
        });
        Schema::table('candidates', function (Blueprint $blueprint) {
            $blueprint->enum('gender', ['male', 'female'])->default('male')->after('middle_name');
            $blueprint->boolean('certificate_provided')->comment = "Предоставлен сертификат (1/0)";
            $blueprint->date('certificate_issued_at')->comment = "Дата выдачи аттестата";
            $blueprint->string('passport_number')->comment = "Серия и номер паспорта";
            $blueprint->string('passport_provided_place')->comment = "Кем выдан";
            $blueprint->date('passport_provided_at')->comment = "Когда выдан";
            $blueprint->string('passport_place_code')->comment = "Код подразделения";
            $blueprint->string('law_address')->comment = "Адрес прописки";
            $blueprint->string('medical_number')->comment = "Номер мед. полиса";
            $blueprint->string('medical_provided_place')->comment = "Кем выдан полис";
            $blueprint->date('medical_provided_at')->comment = "Когда выдан полис";
            $blueprint->string('pension_certificate')->comment = "Номер СНИЛС";
            $blueprint->boolean('photos_provided')->comment = "Фотки предоставлены (1/0)";
            $blueprint->boolean('vaccinations_provided')->comment = "Прививочный серт. предоставлен (1/0)";
            $blueprint->boolean('health_certificate_provided')->comment = "Справка о здоровье (1/0)";
            $blueprint->boolean('certificate_25u_provided')->comment = "Справка 025Ю предоставлена (1/0)";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
