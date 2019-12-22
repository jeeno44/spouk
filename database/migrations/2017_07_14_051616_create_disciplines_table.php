<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('title');
            $table->integer('system_id')->unsigned()->nullable();
            $table->foreign('system_id')->references('id')->on('systems');
            $table->integer('pulpit_id')->unsigned()->nullable();
            $table->foreign('pulpit_id')->references('id')->on('pulpits')->onDelete('cascade');
            $table->integer('college_id')->unsigned()->nullable();
            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
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
        Schema::drop('disciplines');
    }
}
