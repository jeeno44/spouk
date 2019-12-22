<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpoCandidatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('candidates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('college_id', false, true)->nullable();
            $table->integer('school_id', false, true)->nullable();
            $table->integer('region_id', false, true)->nullable();
            $table->integer('city_id', false, true)->nullable();
            $table->integer('education_id', false, true)->nullable();
            $table->string('first_name', 45);
            $table->string('last_name', 45);
            $table->string('middle_name', 45);
            $table->string('address', 255);
            $table->string('phone', 45);
            $table->string('email', 45);
            $table->date('birth_date');
            $table->string('graduatedClass', 45);
            $table->string('graduatedYear', 45);
            $table->string('admissionYear', 45);
            $table->string('certificate', 45);
            $table->string('addEarlierEdu', 45);
            $table->string('addTransferFrom', 45);
            $table->integer('rate');
            $table->integer('gia');
            $table->boolean('is_invalid');
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
		Schema::drop('candidates');
	}

}
