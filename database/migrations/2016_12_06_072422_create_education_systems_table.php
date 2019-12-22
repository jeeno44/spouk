<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('enabled');
            $table->timestamps();
        });
        \App\Models\System::create(['name' => 'Среднее профессионалльное образование', 'enabled' => 1]);
        \App\Models\System::create(['name' => 'Высшее образование', 'enabled' => 1]);
        \App\Models\System::create(['name' => 'Дополнительное образование']);
        Schema::create('college_system', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('college_id')->unsigned()->nullable();
            $table->integer('system_id')->unsigned()->nullable();
            $table->foreign('college_id')->references('id')->on('colleges')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('system_id')->references('id')->on('systems')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
        foreach (\App\Models\College::all() as $college) {
            $college->systems()->attach(1);
        }
        Schema::table('candidates', function (Blueprint $table){
            $table->integer('system_id', false, true)->nullable()->default(1);
        });
        Schema::table('dictionaries', function (Blueprint $table){
            $table->integer('system_id', false, true)->nullable()->default(1);
        });
        Schema::table('protocols', function (Blueprint $table){
            $table->integer('system_id', false, true)->nullable()->default(1);
        });
        Schema::table('subdivisions', function (Blueprint $table){
            $table->integer('system_id', false, true)->nullable()->default(1);
        });
        Schema::table('specializations', function (Blueprint $table){
            $table->integer('system_id', false, true)->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('education_systems');
    }
}
