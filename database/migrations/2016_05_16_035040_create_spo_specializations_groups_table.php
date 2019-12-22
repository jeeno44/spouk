<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpoSpecializationsGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('specializations_groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('specialization_id')->unsigned()->nullable()->index('special_foreign_idx');
			$table->integer('year')->nullable();
			$table->string('title', 45)->nullable();
			$table->integer('kcp')->nullable();
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
		Schema::drop('spo_specializations_groups');
	}

}
