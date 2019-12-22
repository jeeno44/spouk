<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeRolesToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\AccessLevel::create([
            'title'  => 'training',
            'desc'   => 'Сотрудник учебного отдела',
        ]);
        \App\Models\AccessLevel::create([
            'title'  => 'pulpit',
            'desc'   => 'Сотрудник кафедры',
        ]);
        \App\Models\AccessLevel::create([
            'title'  => 'schedule',
            'desc'   => 'Сотрудник отдела расписания',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
