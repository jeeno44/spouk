<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skeds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('system_id')->unsigned()->nullable();
            $table->foreign('system_id')->references('id')->on('systems');
            $table->integer('college_id')->unsigned()->nullable();
            $table->foreign('college_id')->references('id')->on('colleges');
            $table->timestamp('date');
            $table->string('length');
            $table->integer('hall_id')->unsigned()->nullable();
            $table->integer('discipline_id')->unsigned()->nullable();
            $table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete('cascade');
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->integer('hour_type_id')->unsigned()->nullable();
            $table->foreign('hour_type_id')->references('id')->on('hour_types')->onDelete('cascade');
            $table->integer('semester_id');
            $table->timestamps();
        });
    }

    //courses

    //hour_type

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('skeds');
    }
}
