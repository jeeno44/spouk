<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('candidate_order')->delete();
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('college_id')->unsigned()->nullable();
            $table->integer('system_id')->unsigned()->nullable();
            $table->string('title');
            $table->date('date');
            $table->string('number', 60);
            $table->string('file', 60);
            $table->timestamps();
            $table->foreign('college_id')->references('id')->on('colleges')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
        Schema::table('candidate_order', function (Blueprint $table) {
            $table->dropForeign('candidate_order_college_id_foreign');
            $table->dropColumn('college_id');
            $table->dropColumn('title');
            $table->dropColumn('date');
            $table->dropColumn('file');
            $table->dropColumn('number');
            $table->integer('order_id')->unsigned()->nullable();
            $table->dropColumn('system_id');
            $table->dropTimestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
