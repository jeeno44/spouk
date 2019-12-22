<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanDisciplinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_disciplines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('system_id')->unsigned()->nullable();
            $table->foreign('system_id')->references('id')->on('systems');
            $table->integer('college_id')->unsigned()->nullable();
            $table->foreign('college_id')->references('id')->on('colleges');
            $table->integer('plan_id')->unsigned()->nullable();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->integer('semester_id')->unsigned()->default(1);
            $table->integer('discipline_id')->unsigned()->nullable();
            $table->foreign('discipline_id')->references('id')->on('disciplines');
            $table->integer('lecture_hours');
            $table->integer('lab_hours');
            $table->integer('practical_hours');
            $table->integer('solo_hours');
            $table->integer('exam_hours');
            $table->decimal('zet_hours', 8, 2);
            $table->decimal('weeks_count', 8, 2);
            $table->enum('control_type', ['нет', 'зачет', 'экзамен'])->default('нет');
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
        Schema::drop('plan_disciplines');
    }
}
