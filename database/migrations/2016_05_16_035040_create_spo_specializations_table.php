<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpoSpecializationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('specializations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('college_id')->unsigned()->nullable()->index('college_id');
			$table->string('title', 45)->nullable();
			$table->string('code', 45)->nullable();
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
		Schema::drop('spo_specializations');
	}

}
