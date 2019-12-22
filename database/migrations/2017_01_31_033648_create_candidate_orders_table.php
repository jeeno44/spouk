<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('college_id')->unsigned()->nullable();
            $table->integer('system_id')->unsigned()->nullable();
            $table->integer('candidate_id')->unsigned()->nullable();
            $table->string('title', 60);
            $table->date('date');
            $table->string('file', 60);
            $table->string('number', 60);
            $table->timestamps();
            $table->foreign('college_id')->references('id')->on('colleges')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign('candidate_id')->references('id')->on('candidates')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_orders');
    }
}
