<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToDubdivisionsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subdivisions', function (Blueprint $table) {
            $table->string('full_title');
            $table->string('inn');
            $table->string('ogrn');
            $table->string('type');
            $table->string('form');
            $table->string('parent_inn');
            $table->string('views', 1000);
            $table->string('okopf');
            $table->string('okfs');
            $table->string('okved');
            $table->string('strukture');
            $table->string('make_date');
            $table->string('uchred');
            $table->string('law_address');
            $table->string('post_address');
            $table->string('city');
            $table->string('okpo');
            $table->string('oktmo');
            $table->string('okato');
            $table->string('actual_date');
            $table->string('status');
            $table->string('phone');
            $table->string('fax');
            $table->string('email');
            $table->string('site');
            $table->string('licence_number');
            $table->string('licence_date');
            $table->string('licence_serie');
            $table->string('licence_date_finish');
            $table->string('reg_number');
            $table->string('blank_number');
            $table->string('blank_date');
            $table->string('blank_finish');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subdivisions', function (Blueprint $table) {
            //
        });
    }
}
