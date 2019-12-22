<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateParrentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_parents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id');
            $table->enum('type', ['mom','dad', 'other'])->default('mom');
            $table->string('fio');
            $table->string('phone');
            $table->string('year');
            $table->string('workplace');
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
        Schema::drop('candidate_parrents');
    }
}
