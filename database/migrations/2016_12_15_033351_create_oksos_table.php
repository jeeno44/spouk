<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOksosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oksos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('college_id')->unsigned()->nullable();
            $table->integer('system_id')->unsigned()->nullable();
            $table->foreign('college_id')->references('id')->on('colleges')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('system_id')->references('id')->on('systems')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->string('name');
            $table->string('code');
            $table->boolean('is_global');
            $table->timestamps();
        });
        Schema::table('schools', function (Blueprint $table) {
            $table->boolean('is_global');
        });
        Schema::table('specializations', function (Blueprint $table) {
            $table->boolean('is_global');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oksos');
    }
}
