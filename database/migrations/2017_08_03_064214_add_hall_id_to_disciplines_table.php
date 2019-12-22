<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHallIdToDisciplinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disciplines', function (Blueprint $table) {
            $table->integer('hall_id')->unsigned()->nullable();
            $table->foreign('hall_id')->references('id')->on('halls')->onDelete('cascade');
        });
        Schema::table('candidates', function (Blueprint $table) {
            $table->boolean('inflow');
        });
        DB::table('form_training')->where('title', 'Приток')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disciplines', function (Blueprint $table) {
            //
        });
    }
}
