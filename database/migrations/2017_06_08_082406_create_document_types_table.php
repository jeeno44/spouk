<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('template_id');
            $table->timestamps();
        });
        \App\Models\DocumentType::create(['title' => 'Заявление о приеме абитуриента (для русского)', 'template_id' => 2]);
        \App\Models\DocumentType::create(['title' => 'Заявление о приеме абитуриента (для иностранца)', 'template_id' => 3]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('document_types');
    }
}
