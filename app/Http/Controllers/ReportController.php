<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Specialization;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\SpecializationGroup;
use App\Models\Candidate;

class ReportController extends Controller
{
    public function index()
	{
		$listGroups = Candidate::getGroupStudents();
        $listGroupsRecruits = Candidate::getGroupRecruits();
        $candidates = Candidate::where(['college_id' => \Auth::user()->college_id, 'is_student' => 0])
            ->where('system_id', $this->educationSystemId)->get();
		return view('reports.index')->with(['listGroups' => $listGroups, 'listGroupsRecruits' =>  $listGroupsRecruits, 'candidates' => $candidates]);
	}

	public function groupStudent()
	{

		Excel::create('Выгрузка данных по поступившим', function($excel)
		{
    		$excel->sheet('Выгрузка данных по поступившим', function($sheet)
    		{
        		$sheet->loadView('reports.group-students', ['listGroups' => Candidate::getGroupStudents()]);

    		});

		})->export('xls');
	}

	public function groupRecruits()
	{
		Excel::create('Выгрузка призывников', function($excel)
		{
    		$excel->sheet('Выгрузка призывников', function($sheet)
    		{
        		$sheet->loadView('reports.group-recruits', ['listGroups' => Candidate::getGroupRecruits()]);

    		});

		})->export('xls');
	}

	public function groupStudentSingle(Request $request)
	{
		$group_id = $request->input('listGroups');
		$title = SpecializationGroup::find($group_id)->title;

		Excel::create("Состав $title группы", function($excel) use ($group_id)
		{
    		$excel->sheet('Состав группы', function($sheet) use ($group_id)
    		{
        		$sheet->loadView('reports.group-students-single', ['listStudents' => Candidate::getStudentsOfGroup($group_id)]);

    		});

		})->export('xls');
	}

	public function groupStudentParent(Request $request)
	{
		$group_id = $request->input('listGroups');
		$title = SpecializationGroup::find($group_id)->title;

		Excel::create("Родители $title группы", function($excel) use ($group_id)
		{
    		$excel->sheet('Родители группы', function($sheet) use ($group_id)
    		{
        		$sheet->loadView('reports.group-students-parent', ['listStudents' => Candidate::getStudentsOfGroup($group_id)]);

    		});

		})->export('xls');
	}

	public function reportsCommission()
	{
        $specs = Specialization::where('college_id', \Auth::user()->college_id)->where('system_id', $this->educationSystemId)->get();
		return view('reports.commission', compact('specs'));
	}

    public function groupCandidates()
    {

        Excel::create('Выгрузка данных по абитуриентам', function($excel)
        {
            $excel->sheet('Выгрузка данных по абитуриентам', function($sheet)
            {
                $sheet->loadView('reports.group-abirs');

            });

        })->export('xls');
    }
}
