<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpoUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email')->unique('email');
			$table->string('first_name', 45)->nullable();
			$table->string('last_name', 45)->nullable();
			$table->string('middle_name', 45)->nullable();
			$table->string('password', 128)->nullable();
			$table->integer('college_id')->unsigned()->nullable()->index('college_foreign_idx');
			$table->string('photo', 128)->nullable();
			$table->string('phone', 45)->nullable();
			$table->boolean('is_active')->nullable()->default(0);
			$table->string('remember_token', 100)->nullable();
			$table->softDeletes();
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
		Schema::drop('spo_users');
	}

}
