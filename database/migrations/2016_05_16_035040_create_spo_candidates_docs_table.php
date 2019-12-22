<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpoCandidatesDocsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('candidates_docs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('candidate_id')->unsigned()->nullable()->index('candidate_fk_idx');
			$table->string('filename', 128)->nullable();
			$table->string('type', 45)->nullable();
			$table->string('filesize', 45)->nullable();
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
		Schema::drop('spo_candidates_docs');
	}

}
