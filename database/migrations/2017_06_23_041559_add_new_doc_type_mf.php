<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewDocTypeMf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $doc = \App\Models\DocType::find(4);
        $doc->title = 'Медицинский полис';
        $doc->save();
        \App\Models\DocType::create([
            'title' => 'СНИЛС'
        ]);
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
