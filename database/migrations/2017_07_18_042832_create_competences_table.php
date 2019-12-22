<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('title');
            $table->integer('system_id')->unsigned()->nullable();
            $table->foreign('system_id')->references('id')->on('systems');
            $table->integer('college_id')->unsigned()->nullable();
            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('discipline_competence', function (Blueprint $table) {
            $table->integer('discipline_id')->unsigned()->index();
            $table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete('cascade');
            $table->integer('competence_id')->unsigned()->index();
            $table->foreign('competence_id')->references('id')->on('competences')->onDelete('cascade');
            $table->primary(['discipline_id', 'competence_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('competences');
    }
}
