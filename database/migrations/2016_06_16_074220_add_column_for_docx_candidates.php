<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnForDocxCandidates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('candidates', function (Blueprint $table) {
            $table->integer('form_training')->unsigned()->default(1);
            $table->integer('specialization_id')->unsigned()->nullable();
            $table->integer('monetary_basis')->unsigned()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
