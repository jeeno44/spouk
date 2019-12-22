<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('college_id')->unsigned()->nullable();
            $table->integer('system_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('number');
            $table->timestamps();
            $table->foreign('college_id')->references('id')->on('colleges')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
        foreach (\App\Models\College::all() as $col) {
            \App\Models\Course::create(['title' => '1 курс', 'number' => 1, 'college_id' => $col->id, 'system_id' => 1]);
            \App\Models\Course::create(['title' => '2 курс', 'number' => 2, 'college_id' => $col->id, 'system_id' => 1]);
            \App\Models\Course::create(['title' => '3 курс', 'number' => 3, 'college_id' => $col->id, 'system_id' => 1]);
        }
        Schema::table('specializations_groups', function (Blueprint $table) {
            $table->dropColumn('course_id');
            $table->dropColumn('semester_id');
        });
        Schema::table('specializations_groups', function (Blueprint $table) {
            $table->integer('course_id')->unsigned()->nullable();
            $table->integer('semester_id')->default(1);
            $table->foreign('course_id')->references('id')->on('courses')->onUpdate('NO ACTION')->onDelete('SET NULL');
        });
        foreach (\App\Models\SpecializationGroup::all() as $gr) {
            $course = \App\Models\Course::where('college_id', $gr->specialization->college_id)->first();
            $gr->number_course = 3;
            $gr->course_id = $course->id;
            $gr->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courses');
    }
}
