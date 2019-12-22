<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('content');
            $table->boolean('enabled')->default(1);
            $table->string('title');
            $table->string('keywords');
            $table->string('description');
            $table->timestamps();
        });
        \App\Models\Page::create([
            'name'  => 'О проекте',
            'title'  => 'О проекте',
            'slug'  => str_slug('О проекте'),
            'content' => '',
        ]);
        \App\Models\Page::create([
            'name'  => 'Возможности платформы',
            'title'  => 'Возможности платформы',
            'slug'  => str_slug('Возможности платформы'),
            'content' => '',
        ]);
        \App\Models\Page::create([
            'name'  => 'Сотрудничество',
            'title'  => 'Сотрудничество',
            'slug'  => str_slug('Сотрудничество'),
            'content' => '',
        ]);
        \App\Models\Page::create([
            'name'  => 'Партнеры',
            'title'  => 'Партнеры',
            'slug'  => str_slug('Партнеры'),
            'content' => '',
        ]);
        \App\Models\Page::create([
            'name'  => 'Контакты',
            'title'  => 'Контакты',
            'slug'  => str_slug('Контакты'),
            'content' => '',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}
