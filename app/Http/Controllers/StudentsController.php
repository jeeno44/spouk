<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Course;
use App\Models\Order;
use App\Models\Specialization;
use App\Models\SpecializationGroup;
use Illuminate\Http\Request;
use App\Models\CandidateDoc;

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->scripts[] = '/assets/js/students.js';
        $this->scripts[] = '/assets/js/contingent.js';
        parent::__construct();
    }

    public function index()
    {
        $students = Candidate::orderBy('is_invalid1', 'desc')->orderBy('gpa', 'desc')->orderBy('rate', 'desc')
            ->select('*', \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'),
                \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'))
            ->where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('is_student', 1)
            ->where('expelled', 0)
            ->where('final', 0)
            ->where('date_took', '0000-00-00')->paginate(20);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $specs = \App\Models\Specialization::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->orderBy('title')->orderBy('code')
            ->lists('title', 'id')->toArray();
        return view('students.create', compact('specs'));
    }

    public function store(Request $request)
    {
        $validates = [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'certificate' => 'required',
            'reg_number' => 'required',
        ];

        $this->validate($request, $validates);
        $shool_id = $request->get('school_id');

        if (empty($shool_id)) {
            if ($request->has('school_name')) {
                $school = \App\Models\School::where('title', 'like', '%' . $request->get('school_name') . '%')
                    ->where('region_id', $request->get('region_id'))
                    ->where('city_id', $request->get('city_id'))
                    ->first();
                if (!$school) {
                    $schoolObj = new \App\Models\School([
                        'region_id' => $request->get('region_id'),
                        'city_id' => $request->get('city_id'),
                        'title' => $request->get('school_name'),
                        'college_id'    => \Auth::user()->college_id,
                        'system_id ' => $this->educationSystemId,
                    ]);
                    $schoolObj->save();
                    $shool_id = $schoolObj->id;
                } else {
                    $shool_id = $school->id;
                }
            } else {
                $shool_id = null;
            }
        }
        $fields = $request->all();
        $fields['school_id'] = $shool_id;
        $fields['subdivision_id'] = \Auth::user()->subdivision_id;

        if (!empty($fields['birth_date']))
        {
            $date = new \DateTime($fields['birth_date']);
            $fields['birth_date'] = $date->format('Y-m-d');
        }

        $fields['subdivision_id'] = \Auth::user()->subdivision_id;

        if (!empty($fields['certificate_issued_at']))
        {
            $date = new \DateTime($fields['certificate_issued_at']);
            $fields['certificate_issued_at'] = $date->format('Y-m-d');
        }

        if (!empty($fields['passport_provided_at']))
        {
            $date = new \DateTime($fields['passport_provided_at']);
            $fields['passport_provided_at'] = $date->format('Y-m-d');
        }

        if (!empty($fields['date_of_filing']))
        {
            $date = new \DateTime($fields['date_of_filing']);
            $fields['date_of_filing'] = $date->format('Y-m-d');
        }

        if (!empty($fields['date_took'])){
            $date = new \DateTime($fields['date_took']);
            $fields['date_took'] = $date->format('Y-m-d');
        }

        $fields['college_id'] = \Auth::user()->college_id;
        $fields['system_id'] = $this->educationSystemId;
        $fields['is_student'] = 1;
        $candidate = \App\Models\Candidate::create($fields);

        if ($request->has('phones')) {
            foreach ($request->get('phones') as $phone) {
                \DB::table('candidates_phones')->insert([
                    'candidate_id' => $candidate->id,
                    'pcomment' => $phone['comment'],
                    'phone' => $phone['phone'],
                    'author_id' => \Auth::user()->id
                ]);
            }
        }

        if ($request->has('parents')) {
            foreach ($request->get('parents') as $parent) {
                \DB::table('candidate_parents')->insert([
                    'candidate_id' => $candidate->id,
                    'type' => $parent['type'],
                    'phone' => $parent['phone'],
                    'fio' => $parent['fio'],
                    'year' => $parent['year'],
                    'workplace' => $parent['worklace'],
                ]);
            }
        }

        if ($request->has('specialization')) {
            foreach ($request->get('specialization') as $spec) {
                \DB::table('specializations_candidates')->insert([
                    'candidate_id' => $candidate->id,
                    'specialization_id' => $spec,
                    'college_id' => \Auth::user()->college_id
                ]);
            }
        }

        if ($request->has('file_paths')) {
            $fNames = $request->get('file_names');
            $fTypes = $request->get('file_types');
            $fSizes = $request->get('file_sizes');
            $fComments = $request->get('file_comments');
            $docTypes = $request->get('doc_types');
            foreach ($request->get('file_paths') as $key => $path) {
                $fileDir = base_path('docs/college_' . \Auth::user()->college_id . '/candidates/');
                if (!file_exists($fileDir)) {
                    mkdir($fileDir, 0777, true);
                }
                if (file_exists(base_path('docs/tmp/'.$path)) && is_file(base_path('docs/tmp/'.$path))) {
                    \File::move(base_path('docs/tmp/'.$path), $fileDir.$path);
                    CandidateDoc::create([
                        'filename'      => $path,
                        'original_name' => !empty($fNames[$key]) ? $fNames[$key] : '',
                        'fcomment'      => !empty($fComments[$key]) ? $fComments[$key] : '',
                        'type'          => !empty($fTypes[$key]) ? $fTypes[$key] : '',
                        'filesize'      => !empty($fSizes[$key]) ? $fSizes[$key] : '',
                        'doc_type_id'   => !empty($docTypes[$key]) ? $docTypes[$key] : '',
                        'college_id'    => \Auth::user()->college_id,
                        'candidate_id'  => $candidate->id,
                    ]);
                }
            }
        }
        return redirect('dec/students')->with('status', 'Студент создан!');
    }

    public function edit($id)
    {
        $candidate = Candidate::find($id);
        if (!$candidate || $candidate->college_id != \Auth::user()->college_id) {
            abort(404);
        }

        $specs = \App\Models\Specialization::where('college_id', \Auth::user()->college_id)
            ->orderBy('title')->orderBy('code')
            ->where('system_id', $this->educationSystemId)
            ->lists('title', 'id')->toArray();

        return view('students.edit', compact('candidate', 'specs'));
    }

    public function update(Request $request, $id)
    {
        $validates = [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'certificate' => 'required',
            'reg_number' => 'required',
        ];
        $candidate = Candidate::find($id);
        if (!$candidate || $candidate->college_id != \Auth::user()->college_id) {
            abort(404);
        }
        $this->validate($request, $validates);
        $shool_id = $request->get('school_id');
        if (empty($shool_id)) {
            if ($request->has('school_name')) {
                $school = \App\Models\School::where('title', 'like', '%' . $request->get('school_name') . '%')
                    ->where('region_id', $request->get('region_id'))
                    ->where('city_id', $request->get('city_id'))
                    ->first();
                if (!$school) {
                    $schoolObj = new \App\Models\School([
                        'region_id' => $request->get('region_id'),
                        'city_id' => $request->get('city_id'),
                        'title' => $request->get('school_name'),
                        'college_id'    => \Auth::user()->college_id,
                        'system_id ' => $this->educationSystemId,
                    ]);
                    $schoolObj->save();
                    $shool_id = $schoolObj->id;
                } else {
                    $shool_id = $school->id;
                }
            } else {
                $shool_id = null;
            }
        }
        $fields = $request->all();
        $fields['school_id'] = $shool_id;

        if (!empty($fields['birth_date']))
        {
            $date = new \DateTime($fields['birth_date']);
            $fields['birth_date'] = $date->format('Y-m-d');
        }

        $fields['subdivision_id'] = \Auth::user()->subdivision_id;

        if (!empty($fields['certificate_issued_at']))
        {
            $date = new \DateTime($fields['certificate_issued_at']);
            $fields['certificate_issued_at'] = $date->format('Y-m-d');
        }

        if (!empty($fields['passport_provided_at']))
        {
            $date = new \DateTime($fields['passport_provided_at']);
            $fields['passport_provided_at'] = $date->format('Y-m-d');
        }

        if (!empty($fields['date_of_filing']))
        {
            $date = new \DateTime($fields['date_of_filing']);
            $fields['date_of_filing'] = $date->format('Y-m-d');
        }

        $fields['college_id'] = \Auth::user()->college_id;
        if (!$request->has('photos_provided')) {
            $fields['photos_provided'] = 0;
        }
        if (!$request->has('vaccinations_provided')) {
            $fields['vaccinations_provided'] = 0;
        }
        if (!$request->has('health_certificate_provided')) {
            $fields['health_certificate_provided'] = 0;
        }
        if (!$request->has('certificate_25u_provided')) {
            $fields['certificate_25u_provided'] = 0;
        }
        if (!$request->has('certificate_provided')) {
            $fields['certificate_provided'] = 0;
        }
        $candidate->update($fields);

        \DB::table('candidates_phones')->where('candidate_id', $candidate->id)->delete();
        if ($request->has('phones')) {
            foreach ($request->get('phones') as $phone) {
                \DB::table('candidates_phones')->insert([
                    'candidate_id' => $candidate->id,
                    'pcomment' => $phone['comment'],
                    'phone' => $phone['phone'],
                    'author_id' => \Auth::user()->id
                ]);
            }
        }

        \DB::table('candidate_parents')->where('candidate_id', $candidate->id)->delete();
        if ($request->has('parents')) {
            foreach ($request->get('parents') as $parent) {
                \DB::table('candidate_parents')->insert([
                    'candidate_id' => $candidate->id,
                    'type' => $parent['type'],
                    'phone' => $parent['phone'],
                    'fio' => $parent['fio'],
                    'year' => $parent['year'],
                    'workplace' => $parent['worklace'],
                ]);
            }
        }

        \DB::table('specializations_candidates')->where('candidate_id', $candidate->id)->delete();
        if ($request->has('specialization')) {
            foreach ($request->get('specialization') as $spec) {
                \DB::table('specializations_candidates')->insert([
                    'candidate_id' => $candidate->id,
                    'specialization_id' => $spec,
                    'college_id' => \Auth::user()->college_id
                ]);
            }
        }

        \DB::table('candidates_docs')->where('candidate_id', $candidate->id)->delete();
        if ($request->has('file_paths')) {
            $fNames = $request->get('file_names');
            $fTypes = $request->get('file_types');
            $fSizes = $request->get('file_sizes');
            $fComments = $request->get('file_comments');
            $docTypes = $request->get('doc_types');
            foreach ($request->get('file_paths') as $key => $path) {
                $fileDir = base_path('docs/college_' . \Auth::user()->college_id . '/candidates/');
                if (!file_exists($fileDir)) {
                    mkdir($fileDir, 0777, true);
                }
                if (file_exists(base_path('docs/tmp/'.$path)) && is_file(base_path('docs/tmp/'.$path))) {
                    \File::move(base_path('docs/tmp/'.$path), $fileDir.$path);
                }
                CandidateDoc::create([
                    'filename'      => $path,
                    'original_name' => !empty($fNames[$key]) ? $fNames[$key] : '',
                    'fcomment'      => !empty($fComments[$key]) ? $fComments[$key] : '',
                    'type'          => !empty($fTypes[$key]) ? $fTypes[$key] : '',
                    'filesize'      => !empty($fSizes[$key]) ? $fSizes[$key] : '',
                    'doc_type_id'   => !empty($docTypes[$key]) ? $docTypes[$key] : '',
                    'college_id'    => \Auth::user()->college_id,
                    'candidate_id'  => $candidate->id,
                ]);
            }
        }
        return redirect('dec/students')->with('status', 'Студент изменен!');
    }

    public function destroy($id)
    {
        $item = Candidate::find($id);

        if ($item->college_id != \Auth::user()->college_id) {
            abort(404);
        }

        $item->delete();

        return redirect()->back()->with('status', 'Студент удален!');
    }

    public function show($id)
    {
        $candidate = Candidate::find($id);
        if (!$candidate || $candidate->college_id != \Auth::user()->college_id) {
            abort(404);
        }

        return view('students.card', compact('candidate'));
    }

    public function moveContingent()
	{
	    $specs = Specialization::where('college_id', $this->college->id)
            ->where('system_id', $this->educationSystemId)->pluck('id');
	    $courses =  Course::where('college_id', $this->college->id)
            ->where('system_id', $this->educationSystemId)->pluck('title', 'id');
	    $lastCourse = Course::where('college_id', $this->college->id)
            ->where('system_id', $this->educationSystemId)->orderBy('number', 'desc')->first();
        $nextSemesterGroups = SpecializationGroup::where('semester_id', 1)
            ->whereIn('specialization_id', $specs)->where('final', 0)->get();
        $nextCourseGroups = SpecializationGroup::where('semester_id', 2)
            ->whereIn('specialization_id', $specs)->where('final', 0)
            ->where('course_id', '!=', $lastCourse->id)->get();
        $outGroups = SpecializationGroup::where('semester_id', 2)
            ->whereIn('specialization_id', $specs)->where('final', 0)
            ->where('course_id', $lastCourse->id)->get();

        if (\Request::ajax()) {
            return view('contingent.move-inner', compact('nextSemesterGroups', 'courses', 'nextCourseGroups', 'outGroups'));
        } else {
            //SpecializationGroup::whereIn('specialization_id', $specs)
            //    ->update(['semester_id' => 1, 'course_id' => 40, 'final' => 0]);
            return view('contingent.move', compact('nextSemesterGroups', 'courses', 'nextCourseGroups', 'outGroups'));
        }

	}

	public function moveMove($type = 'semester', Request $request)
    {
        $groups = $request->get('groups');
        if ($type == 'semester') {
            SpecializationGroup::whereIn('id', $groups)->update(['semester_id' => 2]);
            $groups = SpecializationGroup::whereIn('id', $groups)->with('candidates')->get();
            $orderId = $this->semesterOrder($groups, $request->get('date'), $request->get('number'));
        }
        if ($type == 'course') {
            $firstGroupId = array_first($groups);
            $group = SpecializationGroup::find($firstGroupId);
            $currentCourse = Course::find($group->course_id);
            $nextCourse = Course::where('number', '>', $currentCourse->number)
                ->where('college_id', $this->college->id)
                ->where('system_id', $this->educationSystemId)
                ->orderBy('number')
                ->first();
            SpecializationGroup::whereIn('id', $groups)->update(['semester_id' => 1, 'course_id' => $nextCourse->id]);
            $groups = SpecializationGroup::whereIn('id', $groups)->with('candidates')->get();
            $orderId = $this->courseOrder($groups, $request->get('date'), $request->get('number'));
            if ($request->has('codes')) {
                foreach ($request->get('codes') as $groupId => $groupCode) {
                    SpecializationGroup::where('id', $groupId)->update(['code' => $groupCode]);
                }
            }
            if ($request->has('titles')) {
                foreach ($request->get('titles') as $groupId => $groupTitle) {
                    SpecializationGroup::where('id', $groupId)->update(['title' => $groupTitle]);
                }
            }
        }
        if ($type == 'out') {
            $groupsOrm = SpecializationGroup::whereIn('id', $groups)->with('candidates')->get();
            $orderId = $this->outOrder($groupsOrm, $request->get('date'), $request->get('number'));
            SpecializationGroup::whereIn('id', $groups)->update(['final' => 1]);
            Candidate::whereIn('group_id', $groups)->where('is_student', 1)
                ->where('expelled', 0)->update(['final' => 1]);
        }
        return $orderId;
    }

    /**
     * @param SpecializationGroup $groups
     * @param $date
     * @param $number
     * @return integer
     */
    protected function semesterOrder($groups, $date, $number)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $headStyle = 'hStyle';
        $candidateIds = [];
        $phpWord->addParagraphStyle($headStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            'spaceAfter' => 300,
        ]);
        $baseStyle = 'bStyle';
        $phpWord->addParagraphStyle($baseStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
            'spaceAfter' => 300,
        ]);
        $leftStyle = 'lStyle';
        $phpWord->addParagraphStyle($leftStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START,
            'spaceAfter' => 300,
        ]);
        $leftSmStyle = 'lStyle';
        $phpWord->addParagraphStyle($leftSmStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START,
            'spaceAfter' => 100,
        ]);
        $section->addText(\Auth::user()->college->title, ['size' => 12], $headStyle);
        $section->addText('ПРИКАЗ '.$number, ['size' => 12], $headStyle);
        $section->addText($date.' г.							                   № '.$number, ['size' => 12], $baseStyle);
        $section->addText('На основании решения  '.\Auth::user()->college->title, ['size' => 12], $baseStyle);
        $section->addText('ПРИКАЗЫВАЮ:', ['size' => 12], $baseStyle);
        foreach ($groups as $group) {
            $section->addText('Перевести на 2 семестр курса № '.$group->course->number.' студентов группы '. $group->title .':', ['size' => 12], $leftStyle);
            $table = $section->addTable();
            foreach ($group->students() as $key => $item) {
                $table->addRow();
                $table->addCell(500)->addText(($key + 1).'.');
                $table->addCell(2000)->addText($item->last_name);
                $table->addCell(2000)->addText($item->first_name);
                $table->addCell(2000)->addText($item->middle_name);
                $table->addCell(2000)->addText('');
                $candidateIds[$item->id] = $item->id;
            }
            $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
        }
        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
        $section->addText('Директор                                                                         _____________', ['size' => 12], $leftStyle);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = str_random().'.docx';
        $objWriter->save(base_path('docs/college_'.\Auth::user()->college_id).'/'.$fileName);
        $order = Order::create([
            'college_id'    => \Auth::user()->college_id,
            'system_id'     => $this->educationSystemId,
            'date'          => date('Y-m-d', strtotime($date)),
            'number'        => $number,
            'title'         => 'Приказ о переводе на второй семестр',
            'file'          => $fileName,
        ]);
        foreach ($candidateIds as $cn) {
            $order->candidates()->attach($cn);
        }
        return $order->id;
    }

    /**
     * @param SpecializationGroup $groups
     * @param $date
     * @param $number
     * @return integer
     */
    protected function courseOrder($groups, $date, $number)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $headStyle = 'hStyle';
        $candidateIds = [];
        $phpWord->addParagraphStyle($headStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            'spaceAfter' => 300,
        ]);
        $baseStyle = 'bStyle';
        $phpWord->addParagraphStyle($baseStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
            'spaceAfter' => 300,
        ]);
        $leftStyle = 'lStyle';
        $phpWord->addParagraphStyle($leftStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START,
            'spaceAfter' => 300,
        ]);
        $leftSmStyle = 'lStyle';
        $phpWord->addParagraphStyle($leftSmStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START,
            'spaceAfter' => 100,
        ]);
        $section->addText(\Auth::user()->college->title, ['size' => 12], $headStyle);
        $section->addText('ПРИКАЗ '.$number, ['size' => 12], $headStyle);
        $section->addText($date.' г.							                   № '.$number, ['size' => 12], $baseStyle);
        $section->addText('На основании решения  '.\Auth::user()->college->title, ['size' => 12], $baseStyle);
        $section->addText('ПРИКАЗЫВАЮ:', ['size' => 12], $baseStyle);
        foreach ($groups as $group) {
            $section->addText('Перевести на 1 семестр курса № '.$group->course->number.' студентов группы '. $group->title .':', ['size' => 12], $leftStyle);
            $table = $section->addTable();
            foreach ($group->students() as $key => $item) {
                $table->addRow();
                $table->addCell(500)->addText(($key + 1).'.');
                $table->addCell(2000)->addText($item->last_name);
                $table->addCell(2000)->addText($item->first_name);
                $table->addCell(2000)->addText($item->middle_name);
                $table->addCell(2000)->addText('');
                $candidateIds[$item->id] = $item->id;
            }
            $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
        }
        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
        $section->addText('Директор                                                                         _____________', ['size' => 12], $leftStyle);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = str_random().'.docx';
        $objWriter->save(base_path('docs/college_'.\Auth::user()->college_id).'/'.$fileName);
        $order = Order::create([
            'college_id'    => \Auth::user()->college_id,
            'system_id'     => $this->educationSystemId,
            'date'          => date('Y-m-d', strtotime($date)),
            'number'        => $number,
            'title'         => 'Приказ о переводе на следующий курс',
            'file'          => $fileName,
        ]);
        foreach ($candidateIds as $cn) {
            $order->candidates()->attach($cn);
        }
        return $order->id;
    }

    /**
     * @param SpecializationGroup $groups
     * @param $date
     * @param $number
     * @return integer
     */
    protected function outOrder($groups, $date, $number)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $headStyle = 'hStyle';
        $candidateIds = [];
        $phpWord->addParagraphStyle($headStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            'spaceAfter' => 300,
        ]);
        $baseStyle = 'bStyle';
        $phpWord->addParagraphStyle($baseStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
            'spaceAfter' => 300,
        ]);
        $leftStyle = 'lStyle';
        $phpWord->addParagraphStyle($leftStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START,
            'spaceAfter' => 300,
        ]);
        $leftSmStyle = 'lStyle';
        $phpWord->addParagraphStyle($leftSmStyle, [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START,
            'spaceAfter' => 100,
        ]);
        $section->addText(\Auth::user()->college->title, ['size' => 12], $headStyle);
        $section->addText('ПРИКАЗ '.$number, ['size' => 12], $headStyle);
        $section->addText($date.' г.							                   № '.$number, ['size' => 12], $baseStyle);
        $section->addText('На основании решения  '.\Auth::user()->college->title, ['size' => 12], $baseStyle);
        $section->addText('ПРИКАЗЫВАЮ:', ['size' => 12], $baseStyle);
        foreach ($groups as $group) {
            $section->addText('Выпустить студентов группы '. $group->title .':', ['size' => 12], $leftStyle);
            $table = $section->addTable();
            foreach ($group->students() as $key => $item) {
                $table->addRow();
                $table->addCell(500)->addText(($key + 1).'.');
                $table->addCell(2000)->addText($item->last_name);
                $table->addCell(2000)->addText($item->first_name);
                $table->addCell(2000)->addText($item->middle_name);
                $table->addCell(2000)->addText('');
                $candidateIds[$item->id] = $item->id;
            }
            $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
        }
        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
        $section->addText('Директор                                                                         _____________', ['size' => 12], $leftStyle);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = str_random().'.docx';
        $objWriter->save(base_path('docs/college_'.\Auth::user()->college_id).'/'.$fileName);
        $order = Order::create([
            'college_id'    => \Auth::user()->college_id,
            'system_id'     => $this->educationSystemId,
            'date'          => date('Y-m-d', strtotime($date)),
            'number'        => $number,
            'title'         => 'Приказ о выпуске',
            'file'          => $fileName,
        ]);
        foreach ($candidateIds as $cn) {
            $order->candidates()->attach($cn);
        }
        return $order->id;
    }

	public function outputContingent()
	{
		$listGroup = SpecializationGroup::join('specializations', 'specializations.id', '=', 'specializations_groups.specialization_id')
            ->where('specializations.college_id', $this->college->id)
            ->where('final', 0)
            ->select('specializations_groups.*')->get();

		return view('contingent.output', compact('listGroup'));
	}

	public function outputStudents($group_id)
	{
		$group = SpecializationGroup::find($group_id);
		$listStudent = $group->students();
		return view('contingent.output-students', compact('listStudent', 'group'));
	}

	public function output()
    {
        $students = Candidate::where('is_student', 1)->where('expelled', 0)->where('final', 1)->orderBy('last_name')->paginate(20);
        return view('students.output', compact('students'));
    }

    public function deduct()
    {
        $students = Candidate::where('is_student', 1)->where('expelled', 1)->orderBy('last_name')->paginate(20);
        return view('students.deduct', compact('students'));
    }


}
