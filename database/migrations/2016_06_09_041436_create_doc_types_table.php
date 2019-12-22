<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
        Schema::table('candidates_docs', function (Blueprint $table) {
            $table->integer('doc_type_id')->unsigned()->nullable();
        });
        \App\Models\DocType::create(['title' => 'Документ удостоверяющий личность']);
        \App\Models\DocType::create(['title' => 'Аттестат']);
        \App\Models\DocType::create(['title' => 'Медицинская справка']);
        \App\Models\DocType::create(['title' => 'Страховой полис']);
        \App\Models\DocType::create(['title' => 'Иной документ']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doc_types');
    }
}
