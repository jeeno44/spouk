<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnForGroupsV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('specializations_groups', function (Blueprint $table) {
            $table->integer('course_id')->unsigned()->nullable();
            $table->integer('semester_id')->unsigned()->nullable();
            $table->smallInteger('number_course')->default(0);

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
