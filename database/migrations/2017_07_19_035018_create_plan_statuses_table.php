<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
        \App\Models\PlanStatus::create(['title' => 'Формируется']);
        \App\Models\PlanStatus::create(['title' => 'Происходит распределение академической нагрузки по кафедрам']);
        \App\Models\PlanStatus::create(['title' => 'Формируется расписание']);
        \App\Models\PlanStatus::create(['title' => 'Передан на подпись']);
        \App\Models\PlanStatus::create(['title' => 'Утвержден']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plan_statuses');
    }
}
