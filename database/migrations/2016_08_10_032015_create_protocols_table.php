<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocols', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['protocol', 'order'])->default('protocol');
            $table->string('protocol_date')->nullable();
            $table->string('protocol_number')->nullable();
            $table->string('order_date')->nullable();
            $table->string('order_number')->nullable();
            $table->string('enroll_date')->nullable();
            $table->string('file')->nullable();
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
        Schema::drop('protocols');
    }
}
