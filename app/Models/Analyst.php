<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Analyst extends Model
{
    static public function getStatistics()
	{
		$resultCollection = collect();

		$regions = Region::orderBy('title')->get();
    	foreach ( $regions as $region )
    	{
        	$colleges = College::where('region_id', $region->id)->orderBy('title')->get();
        	if ($colleges->count() == 0)
            	continue;

			$collegeCollection = collect();

        	foreach($colleges as $college)
        	{
				$countCandidate = Candidate::where('college_id', $college->id)->get()->count();
				$countSpecialization = Specialization::where('college_id', $college->id)->get()->count();

				$countTeacher = 0;
            	$users = User::where('college_id', $college->id)->get();
            	foreach ($users as $teacher)
                if ($teacher->hasRole('teacher') )
                    $countTeacher++;

                $id_users     = $users->pluck('id');
            	$countAuthTotal = \DB::table('log_messages')->where('log_type_id', 1)->where('created_at', '>', '2016-06-01')->whereIn('user_id', $id_users)->count();
            	$countAuthWeek  = \DB::table('log_messages')->where('log_type_id', 1)->whereRaw('created_at > NOW() - INTERVAL 7 DAY')->whereIn('user_id', $id_users)->count();

				$collegeCollection->push(['name' 		   => $college->title, 'countTeacher'        => $countTeacher,
										  'countCandidate' => $countCandidate, 'countSpecialization' => $countSpecialization,
										  'countAuthTotal' => $countAuthTotal, 'countAuthWeek'       => $countAuthWeek]);
        	}

        	$resultCollection->push(['name' => $region->title,                                      'countTeacher'   => $collegeCollection->sum('countTeacher'),
        							 'countCandidate' => $collegeCollection->sum('countCandidate'), 'countSpecialization' => $collegeCollection->sum('countSpecialization'),
        							 'countAuthTotal' => $collegeCollection->sum('countAuthTotal'), 'countAuthWeek'       => $collegeCollection->sum('countAuthWeek')]);


        	$resultCollection = $resultCollection->merge($collegeCollection);
    	}

    	return $resultCollection;
	}

	static public function getDynamics()
    {
        return DB::table('candidates')
            ->select(DB::raw("DATE_FORMAT(created_at, '%m.%Y') as created_at, count(*) AS total"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m.%Y')"))
            ->orderBy("created_at")
            ->get();
    }
}
