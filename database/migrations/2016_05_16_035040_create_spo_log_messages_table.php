<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpoLogMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log_messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('log_type_id')->unsigned()->nullable()->index('log_type_id');
			$table->integer('user_id')->unsigned()->nullable()->index('user_id');
			$table->text('message', 65535)->nullable();
			$table->text('objects', 65535)->nullable();
			$table->index(['log_type_id','user_id'], 'where_all');
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
		Schema::drop('spo_log_messages');
	}

}
