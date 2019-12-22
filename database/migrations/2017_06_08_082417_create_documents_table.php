<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_type_id')->unsigned()->nullable();
            $table->integer('candidate_id')->unsigned()->nullable();
            $table->string('title')->default('');
            $table->string('docx_link', 500)->default('');
            $table->string('pdf_link', 500)->default('');
            $table->integer('out_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('documents');
    }
}
