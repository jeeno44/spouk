<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Candidate;

class SetNameNumberToAllStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $groups = \App\Models\SpecializationGroup::all();
        foreach ($groups as $group) {
            $candidates = Candidate::where('group_id', $group->id)->where('is_student', 1)->orderBy('last_name')->get();
            foreach ($candidates as $key => $candidate) {
                $candidate->update(['name_number' => mb_substr($candidate->last_name, 0, 1) . '-' . mb_substr($group->year, 2) . '-' . ($key + 1)]);
            }
        }

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
