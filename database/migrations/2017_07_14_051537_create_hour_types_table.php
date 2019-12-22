<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHourTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hour_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
        \App\Models\HourType::create(['title' => 'Лекция']);
        \App\Models\HourType::create(['title' => 'Лабораторная']);
        \App\Models\HourType::create(['title' => 'Практика']);
        \App\Models\HourType::create(['title' => 'СРС']);
        \App\Models\HourType::create(['title' => 'Контроль']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hour_types');
    }
}
