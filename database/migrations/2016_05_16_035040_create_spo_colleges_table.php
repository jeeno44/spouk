<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpoCollegesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('colleges', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('city_id')->unsigned()->nullable()->index('city_foreign_idx');
			$table->integer('region_id')->unsigned()->nullable()->index('region_foreign_idx');
			$table->string('title')->nullable();
			$table->string('address')->nullable();
			$table->string('logo')->nullable();
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
		Schema::drop('spo_colleges');
	}

}
