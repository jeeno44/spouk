<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

use App\Models\Candidate;
use App\Models\CandidateDoc;

class CandidatesController extends Controller
{

    public function index()
    {
        $candidates = \App\Models\Candidate::orderBy('is_invalid1', 'desc')->orderBy('gpa', 'desc')->orderBy('rate', 'desc')
            ->select('*', \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'),
                \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'))
            ->where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')
            ->where('is_student', 0)->paginate(20);

        $offCandidates = \App\Models\Candidate::orderBy('is_invalid1', 'desc')->orderBy('gpa', 'desc')->orderBy('rate', 'desc')
            ->select('*', \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'),
                \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'))
            ->where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '!=' ,'0000-00-00')
            ->where('is_student', 0)->get();

        $specs = \App\Models\Specialization::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->orderBy('title')->orderBy('code')->get();
        return view('candidates.index', compact('candidates', 'specs', 'offCandidates'));
    }

    public function create()
    {
        $specs = \App\Models\Specialization::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->orWhere('is_global', 1)->where('system_id', $this->educationSystemId)
            ->orderBy('title')->orderBy('code')
            ->lists('title', 'id')->toArray();
        return view('candidates.create', compact('specs'));
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

        if ( $fields['birth_date'] )
        {
            $date = new \DateTime($fields['birth_date']);
            $fields['birth_date'] = $date->format('Y-m-d');
        }

        if ( $fields['certificate_issued_at'] )
        {
            $date = new \DateTime($fields['certificate_issued_at']);
            $fields['certificate_issued_at'] = $date->format('Y-m-d');
        }

        if ( $fields['passport_provided_at'] )
        {
            $date = new \DateTime($fields['passport_provided_at']);
            $fields['passport_provided_at'] = $date->format('Y-m-d');
        }

        if ( $fields['date_of_filing'] )
        {
            $date = new \DateTime($fields['date_of_filing']);
            $fields['date_of_filing'] = $date->format('Y-m-d');
        }

        if ($fields['date_took'])  {
            $date = new \DateTime($fields['date_took']);
            $fields['date_took'] = $date->format('Y-m-d');
        }

        $fields['college_id'] = \Auth::user()->college_id;
        $fields['system_id'] = $this->educationSystemId;
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
        if ($request->hasFile('cert')) {
            $fName = str_random().'.'.$request->file('cert')->getClientOriginalExtension();
            $oName = $request->file('cert')->getClientOriginalName();
            $type = $request->file('cert')->getType();
            $docTypeId = 2;
            $fileDir = base_path('docs/college_' . \Auth::user()->college_id . '/candidates/');
            $request->file('cert')->move($fileDir, $fName);
            CandidateDoc::create([
                'filename'      => $fName,
                'original_name' => $oName,
                'type'          => $type,
                'doc_type_id'   => $docTypeId,
                'college_id'    => \Auth::user()->college_id,
                'candidate_id'  => $candidate->id,
            ]);
        }
        if ($request->hasFile('passport')) {
            $fName = str_random().'.'.$request->file('passport')->getClientOriginalExtension();
            $oName = $request->file('passport')->getClientOriginalName();
            $type = $request->file('passport')->getType();
            $docTypeId = 1;
            $fileDir = base_path('docs/college_' . \Auth::user()->college_id . '/candidates/');
            $request->file('passport')->move($fileDir, $fName);
            CandidateDoc::create([
                'filename'      => $fName,
                'original_name' => $oName,
                'type'          => $type,
                'doc_type_id'   => $docTypeId,
                'college_id'    => \Auth::user()->college_id,
                'candidate_id'  => $candidate->id,
            ]);
        }
        if ($request->hasFile('med')) {
            $fName = str_random().'.'.$request->file('med')->getClientOriginalExtension();
            $oName = $request->file('med')->getClientOriginalName();
            $type = $request->file('med')->getType();
            $docTypeId = 4;
            $fileDir = base_path('docs/college_' . \Auth::user()->college_id . '/candidates/');
            $request->file('med')->move($fileDir, $fName);
            CandidateDoc::create([
                'filename'      => $fName,
                'original_name' => $oName,
                'type'          => $type,
                'doc_type_id'   => $docTypeId,
                'college_id'    => \Auth::user()->college_id,
                'candidate_id'  => $candidate->id,
            ]);
        }
        if ($request->hasFile('snils')) {
            $fName = str_random().'.'.$request->file('snils')->getClientOriginalExtension();
            $oName = $request->file('snils')->getClientOriginalName();
            $type = $request->file('snils')->getType();
            $docTypeId = 5;
            $fileDir = base_path('docs/college_' . \Auth::user()->college_id . '/candidates/');
            $request->file('snils')->move($fileDir, $fName);
            CandidateDoc::create([
                'filename'      => $fName,
                'original_name' => $oName,
                'type'          => $type,
                'doc_type_id'   => $docTypeId,
                'college_id'    => \Auth::user()->college_id,
                'candidate_id'  => $candidate->id,
            ]);
        }
        return redirect('enroll/candidates')->with('status', 'Абитуриент создан!');
    }

    public function show($id)
    {
        $candidate = Candidate::find($id);
        if (!$candidate || $candidate->college_id != \Auth::user()->college_id) {
            abort(404);
        }
        $statement = Document::where('candidate_id', $id)->whereIn('document_type_id', [1, 2])->where('docx_link', '!=', '')->orderBy('id', 'desc')->first();
        return view('candidates.card', compact('candidate', 'statement'));
    }

    public function edit($id)
    {
        $candidate = Candidate::find($id);
        if (!$candidate || $candidate->college_id != \Auth::user()->college_id) {
            abort(404);
        }

        $specs = \App\Models\Specialization::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->orWhere('is_global', 1)->where('system_id', $this->educationSystemId)
            ->orderBy('title')->orderBy('code')
            ->lists('title', 'id')->toArray();

        return view('candidates.edit', compact('candidate', 'specs'));
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

        if ( $fields['birth_date'] )
        {
            $date = new \DateTime($fields['birth_date']);
            $fields['birth_date'] = $date->format('Y-m-d');
        }

        $fields['subdivision_id'] = \Auth::user()->subdivision_id;

        if ( $fields['certificate_issued_at'] )
        {
            $date = new \DateTime($fields['certificate_issued_at']);
            $fields['certificate_issued_at'] = $date->format('Y-m-d');
        }

        if ( $fields['passport_provided_at'] )
        {
            $date = new \DateTime($fields['passport_provided_at']);
            $fields['passport_provided_at'] = $date->format('Y-m-d');
        }

        if ( $fields['date_of_filing'] )
        {
            $date = new \DateTime($fields['date_of_filing']);
            $fields['date_of_filing'] = $date->format('Y-m-d');
        }

        if ($fields['date_took'])  {
            $date = new \DateTime($fields['date_took']);
            $fields['date_took'] = $date->format('Y-m-d');
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
        return redirect('enroll/candidates')->with('status', 'Абитуриент изменен!');
    }

    public function destroy($id)
    {
        $item = Candidate::find($id);

        if ($item->college_id != \Auth::user()->college_id) {
            abort(404);
        }

        $item->delete();

        return redirect()->back()->with('status', 'Абитуриент удален!');
    }
}
