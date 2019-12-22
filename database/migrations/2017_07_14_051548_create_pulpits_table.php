<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePulpitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pulpits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('system_id')->unsigned()->nullable();
            $table->foreign('system_id')->references('id')->on('systems');
            $table->integer('college_id')->unsigned()->nullable();
            $table->foreign('college_id')->references('id')->on('colleges');
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
        Schema::drop('pulpits');
    }
}
