<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\College;
use App\Models\Region;
use App\Models\School;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AjaxController extends Controller
{

    /**
     * Подгружаем кандитатов [AJAX]
     *
     * @param  Request $request
     * @return string
     * @access public
     */

    public function candidates(Request $request)
    {
        $buildQuery = \App\Models\Candidate::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')->where('is_student', 0);
        if ($request->has('subID') && !empty($request->get('subID'))) {
            $specs = Specialization::where('subdivision_id', $request->get('subID'))
                ->where('system_id', $this->educationSystemId)
                ->lists('id')
                ->toArray();
            $buildQuery = \App\Models\Candidate::where('college_id', \Auth::user()->college_id)->whereIn('specialization_id', $specs);
        }
        if ($request->has('specID') && !empty($request->get('specID'))) {
            $spec = Specialization::find($request->get('specID'));
            $buildQuery->where('specialization_id', $spec->id);
        }

        switch ($request->get('filter')) {
            case 'FIO':
                $buildQuery->select('*', \DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) as fio'),
                    \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'),
                    \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'))
                    ->orderBy('fio', $request->get('how'))->orderBy('first_name', $request->get('how'));
                break;
            case 'RATE':
                $buildQuery->select('*', \DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) as fio'),
                    \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'),
                    \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'))
                    ->orderBy('gpa', $request->get('how'))->orderBy('rate', $request->get('how'));
                break;
            case 'AGE':
                $buildQuery->select('*', \DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) as fio'),
                    \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'),
                    \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'))
                    ->orderBy('age', $request->get('how'));
                break;
            default:
                $buildQuery->select('*', \DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) as fio'),
                    \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'),
                    \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'))->orderBy('is_invalid1', 'desc')
                    ->orderBy('gpa', $request->get('how'))->orderBy('rate', $request->get('how'));

        }
        $candidates = $buildQuery->paginate(20);

        $response = array();
        $response['table'] = (string)view('candidates.ajaxCandidates', compact('candidates'));
        $response['pages'] = (string)view('candidates.ajaxCandidatesPages', compact('candidates'));;

        return \Response::json($response);
    }

    public function students(Request $request)
    {
        $buildQuery = \App\Models\Candidate::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')
            ->where('is_student', 1)
            ->where('expelled', 0)
            ->where('final', 0);
        if ($request->has('specID') && !empty($request->get('specID'))) {
            $buildQuery->where('group_id', $request->get('specID'));
        }
        switch ($request->get('filter')) {
            case 'FIO':
                $buildQuery->select('*', \DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) as fio'),
                    \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'),
                    \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'))
                    ->orderBy('fio', $request->get('how'))->orderBy('first_name', $request->get('how'));
                break;
            case 'RATE':
                $buildQuery->select('*', \DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) as fio'),
                    \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'),
                    \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'))
                    ->orderBy('gpa', $request->get('how'))->orderBy('rate', $request->get('how'));
                break;
            case 'AGE':
                $buildQuery->select('*', \DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) as fio'),
                    \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'),
                    \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'))
                    ->orderBy('age', $request->get('how'));
                break;
            default:
                $buildQuery->select('*', \DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) as fio'),
                    \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'),
                    \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'))->orderBy('is_invalid1', 'desc')
                    ->orderBy('gpa', $request->get('how'))->orderBy('rate', $request->get('how'));

        }
        $students = $buildQuery->paginate(20);

        $response = array();
        $response['table'] = (string)view('students.ajax-students', compact('students'));
        $response['pages'] = (string)view('students.ajax-stundents-pages', compact('students'));;

        return \Response::json($response);
    }

    /**
     * Сохраняем рейтинг [AJAX]
     *
     * @param  Request $request
     * @return void
     * @access public
     */

    public function saveRate(Request $request)
    {
        $candidate = \App\Models\Candidate::find($request->get('candidate_id'));
        $candidate->rate = $request->get('rate');
        $candidate->update();
    }

}