<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcessLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('access_level_user');
        Schema::dropIfExists('access_levels');
        Schema::create('access_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('desc');
            $table->timestamps();
        });
        Schema::create('access_level_user', function (Blueprint $table) {
            $table->integer('access_level_id')->unsigned()->index();
            $table->foreign('access_level_id')->references('id')->on('access_levels')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['access_level_id', 'user_id']);
        });

        \App\Models\AccessLevel::create(['title' => 'pk', 'desc' => 'Приемная комиссия']);
        \App\Models\AccessLevel::create(['title' => 'ps', 'desc' => 'Преподавательский состав']);
        \App\Models\AccessLevel::create(['title' => 'sd', 'desc' => 'Сотрудник деканата']);
        \App\Models\AccessLevel::create(['title' => 'ck', 'desc' => 'Цикловая комиссия']);
        \App\Models\AccessLevel::create(['title' => 'adm', 'desc' => 'Администрация']);
        $teacher = \App\Models\Role::where('title',  'teacher')->first();
        foreach ($teacher->users as $teacher) {
            $teacher->access()->attach(2);
            if ($teacher->is_commission == 1) {
                $teacher->access()->attach(1);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('access_levels');
    }
}
