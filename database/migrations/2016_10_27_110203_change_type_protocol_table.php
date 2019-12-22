<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeProtocolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('protocols', function (Blueprint $table) {
            DB::statement('ALTER TABLE spo_protocols MODIFY COLUMN type VARCHAR(32)');

            DB::statement('ALTER TABLE spo_protocols MODIFY COLUMN protocol_date date');
            DB::statement('ALTER TABLE spo_protocols MODIFY COLUMN order_date date');
            DB::statement('ALTER TABLE spo_protocols MODIFY COLUMN enroll_date date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('protocols', function (Blueprint $table) {
            //
        });
    }
}
