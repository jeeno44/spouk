<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Order;
use App\Models\Protocol;
use App\Models\Specialization;
use App\Models\SpecializationGroup;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class EnrollmentController extends Controller
{
    public function index()
    {
        $candidates = Candidate::orderBy('is_invalid1', 'desc')->orderBy('gpa', 'desc')->orderBy('rate', 'desc')
            ->select('*', \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'),
                DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'))
            ->where('certificate_provided', 1)/*->where('form_training', 1)*/
            ->where('system_id', $this->educationSystemId)
            ->where('college_id', \Auth::user()->college_id)->where('date_took', '0000-00-00')->where('is_student', 0)->get();
        $notApprovedOrder = \App\Models\Protocol::where('type', 'order')
            ->where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('approved', 0)
            ->orderBy('id', 'desc')
            ->first();
        $specs =  Specialization::where('college_id', \Auth::user()->college_id)->where('system_id', $this->educationSystemId)->orderBy('title')->orderBy('code')->get();
        $groups = SpecializationGroup::whereIn('specialization_id', $specs->pluck('id'))->where('final', 0)->lists('title', 'id')->toArray();

        return view('enrollment.index', compact('candidates', 'specs', 'groups', 'notApprovedOrder'));
    }

    public function getGroupBySpec($id = null)
    {
        if (!$id) {
            $groups = getFilterGroups(\Auth::user()->college_id);
        } else {
            $groups = getFilterGroups(\Auth::user()->college_id, $id);
        }
        return view('enrollment.groups', compact('groups'));
    }
    
    public function filter(Request $request)
    {
        $data = $request->all();
        if (!empty($data['group_id']) && !empty($data['specialization_id'])) {
            $group = SpecializationGroup::find($data['group_id']);
            if ($group->specialization_id != $data['specialization_id']) {
                $data['group_id'] = null;
            }
        }
        $buildQuery = Candidate::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')->where('is_student', 0);
        $buildQuery->select('*', \DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) as fio'),
            \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'),
            \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'))
            ->orderBy('is_invalid1', 'desc')
            ->orderBy('gpa', 'desc')
            ->orderBy('rate', 'desc');

        if (!empty($data['specialization_id'])) {
            $buildQuery->where('specialization_id', $data['specialization_id']);
        }
        if (!empty($data['certificate_provided'])) {
            $buildQuery->where('certificate_provided', 1);
        } else {
            $buildQuery->where('certificate_provided', 0);
        }
        if (!empty($data['group_id'])) {
            $buildQuery->where('group_id', $data['group_id']);
        }
        if (!empty($data['monetary_basis'])) {
            $buildQuery->where('monetary_basis', $data['monetary_basis']);
        }
        if (!empty($data['form_training'])) {
            $buildQuery->where('form_training', $data['form_training']);
        }
        if (!empty($data['education_id'])) {
            $buildQuery->where('education_id', $data['education_id']);
        }
        $candidates = $buildQuery->get();
        return view('enrollment.ajaxCandidates', compact('candidates'));
    }

    public function setGroup(Request $request, $group)
    {
        if ($request->get('status') == 1) {
            \DB::table('candidates')->whereIn('id', $request->get('candidates'))->update(['group_id' => $group]);
        } else {
            \DB::table('candidates')->whereIn('id', $request->get('candidates'))->update(['group_id' => null]);
        }
        $group = SpecializationGroup::find($group);
        $candidates = Candidate::where('group_id', $group->id)->orderBy('last_name')->get();
        foreach ($candidates as $key => $candidate) {
            $candidate->update(['name_number' => mb_substr($candidate->last_name, 0, 1) . '-' . mb_substr($group->year, 2) . '-' . ($key + 1)]);
        }
    }

    public function protocol(Request $request)
    {
        $specs = Specialization::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->lists('id');
        $groups = SpecializationGroup::whereIn('specialization_id', $specs)->get();
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $candidateIds = [];
        $headStyle = 'hStyle';

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

        $fancyTableStyleName = 'Список к зачислению';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 20, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::START);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle);

        $date = $request->has('protocol_date') ? $request->get('protocol_date') : date('d.m.Y');
        $number = $request->has('protocol_number') ? $request->get('protocol_number') : '_____';
        $section->addText(\Auth::user()->college->title, ['size' => 12], $headStyle);
        $section->addText('ПРОТОКОЛ ЗАСЕДАНИЯ ПРИЕМНОЙ КОМИССИИ от '.$date.' г. № '.$number, ['size' => 12], $headStyle);
        $section->addText('Присутствовали: ___________________________________________________________', ['size' => 12], $baseStyle);
        $section->addText('Слушали: __________________________________________________________________', ['size' => 12], $baseStyle);
        $section->addText('Постановили: на основании результатов освоения поступающими образовательной программы основного общего, среднего (полного) общего, начального профессионального образования, указанных в представленных поступающими документах об образовании, приемная комиссия рекомендует к зачислению в '.\Auth::user()->college->title.':', ['size' => 12], $baseStyle);

        $after9 = Candidate::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')
            ->whereNotNull('group_id')
            ->where('education_id', 1)
            ->where('is_student', 0)
            ->count();

        if ($after9) {
            $section->addText('После 9 класса', ['size' => 12, 'bold' => true], $leftStyle);
            foreach ($groups as $group) {
                $candidates = Candidate::where('group_id', $group->id)
                    ->where('system_id', $this->educationSystemId)
                    ->where('date_took', '0000-00-00')
                    ->where('education_id', 1)
                    ->where('is_student', 0)
                    ->get();
                if ($candidates->count()) {
                    $section->addText($group->title, ['size' => 12, 'bold' => true, 'underline' => 'line'], $leftSmStyle);
                    if ($candidates->where('monetary_basis', 1)->count()) {
                        $table = $section->addTable($fancyTableStyleName);
                        foreach ($candidates->where('monetary_basis', 1)->all() as $item) {
                            $table->addRow();
                            $table->addCell(2000)->addText($item->last_name);
                            $table->addCell(2000)->addText($item->first_name);
                            $table->addCell(2000)->addText($item->middle_name);
                            $table->addCell(2000)->addText($item->gpa);
                            $candidateIds[$item->id] = $item->id;
                        }
                        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
                    }
                    if ($candidates->where('monetary_basis', 2)->count()) {
                        $table = $section->addTable($fancyTableStyleName);
                        foreach ($candidates->where('monetary_basis', 2)->all() as $item) {
                            $table->addRow();
                            $table->addCell(2000)->addText($item->last_name);
                            $table->addCell(2000)->addText($item->first_name);
                            $table->addCell(2000)->addText($item->middle_name);
                            $table->addCell(2000)->addText('');
                            $candidateIds[$item->id] = $item->id;
                        }
                        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
                    }
                }
            }
        }


        $after11 = Candidate::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')
            ->whereNotNull('group_id')
            ->where('is_student', 0)
            ->where('education_id', '>', 1)
            ->count();

        if ($after11) {
            $section->addText('После 11 класса', ['size' => 12, 'bold' => true], $leftStyle);
            foreach ($groups as $group) {
                $candidates = Candidate::where('group_id', $group->id)
                    ->where('system_id', $this->educationSystemId)
                    ->where('date_took', '0000-00-00')
                    ->where('is_student', 0)
                    ->where('education_id', '>', 1)
                    ->get();
                if ($candidates->count()) {
                    $section->addText($group->title, ['size' => 12, 'bold' => true, 'underline' => 'single'], $leftSmStyle);
                    if ($candidates->where('monetary_basis', 1)->count()) {
                        $table = $section->addTable($fancyTableStyleName);
                        foreach ($candidates->where('monetary_basis', 1)->all() as $item) {
                            $table->addRow();
                            $table->addCell(2000)->addText($item->last_name);
                            $table->addCell(2000)->addText($item->first_name);
                            $table->addCell(2000)->addText($item->middle_name);
                            $table->addCell(2000)->addText('');
                            $candidateIds[$item->id] = $item->id;
                        }
                        $section->addText('', ['size' => 12, 'bold' => true], $leftSmStyle);
                    }
                    if ($candidates->where('monetary_basis', 2)->count()) {
                        $table = $section->addTable($fancyTableStyleName);
                        foreach ($candidates->where('monetary_basis', 2)->all() as $item) {
                            $table->addRow();
                            $table->addCell(2000)->addText($item->last_name);
                            $table->addCell(2000)->addText($item->first_name);
                            $table->addCell(2000)->addText($item->middle_name);
                            $table->addCell(2000)->addText('');
                            $candidateIds[$item->id] = $item->id;
                        }
                        $section->addText('', ['size' => 12, 'bold' => true], $leftSmStyle);
                    }
                }
            }
        }

        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
        $section->addText('Председатель приемной комиссии	   			                    _____________', ['size' => 12], $leftStyle);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = str_random().'.docx';

        $objWriter->save(base_path('docs/college_'.\Auth::user()->college_id).'/'.$fileName);

        $protocol = Protocol::create([
            'type'              => 'protocol',
            'protocol_date'     => datetime('Y-m-d', $date),
            'protocol_number'   => $number,
            'file'              => $fileName,
            'college_id'        => \Auth::user()->college_id,
            'system_id'         => $this->educationSystemId,
        ]);

		$protocol->attachCandidate($candidateIds);

		// не понятно зачем
        \DB::table('candidates')->whereIn('id', $candidateIds)->update(['protocol_id' => $protocol->id]);

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="Протокол работы приемной комиссии от '.$date.'.docx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.date('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        $objWriter->save('php://output');
    }

    public function order(Request $request)
    {
        $specs = Specialization::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)->lists('id');
        $groups = SpecializationGroup::whereIn('specialization_id', $specs)->get();
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $candidateIds = [];
        $headStyle = 'hStyle';
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
        $protocol_date = $request->has('protocol_date') ? $request->get('protocol_date') : date('d.m.Y');
        $date = $request->has('order_date') ? $request->get('order_date') : date('d.m.Y');
        $number = $request->has('order_number') ? $request->get('order_number') : '_____';
        $section->addText(\Auth::user()->college->title, ['size' => 12], $headStyle);
        $section->addText('ПРИКАЗ'.$number, ['size' => 12], $headStyle);
        $section->addText($date.' г.							                   № '.$number, ['size' => 12], $baseStyle);
        $section->addText('На основании решения приемной комиссии  '.\Auth::user()->college->title.' (протокол заседания от '.$protocol_date.' г.)', ['size' => 12], $baseStyle);
        $section->addText('ПРИКАЗЫВАЮ:', ['size' => 12], $baseStyle);

        $after9 = Candidate::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')
            ->where('is_student', 0)
            ->whereNotNull('group_id')
            ->where('education_id', 1)
            ->count();
        if ($after9) {
            $section->addText('1. Зачислить в  '.\Auth::user()->college->title.' на базе основного общего образования:', ['size' => 12], $leftStyle);
            foreach ($groups as $group) {
                $candidates = Candidate::where('group_id', $group->id)
                    ->where('system_id', $this->educationSystemId)
                    ->where('date_took', '0000-00-00')
                    ->where('education_id', 1)
                    ->where('is_student', 0)
                    ->get();
                if ($candidates->count()) {
                    if ($candidates->where('monetary_basis', 1)->count()) {
                        $section->addText('в группу '.$group->title.' на бюджетной основе', ['size' => 12, 'underline' => 'single'], $leftSmStyle);
                        $table = $section->addTable();
                        foreach ($candidates->where('monetary_basis', 1)->all() as $key => $item) {
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
                    if ($candidates->where('monetary_basis', 2)->count()) {
                        $section->addText('в группу '.$group->title.' на платной основе', ['size' => 12, 'underline' => 'single'], $leftSmStyle);
                        $table = $section->addTable();
                        foreach ($candidates->where('monetary_basis', 2)->all() as $key => $item) {
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
                }
            }
        }

        $after11 = Candidate::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')
            ->whereNotNull('group_id')
            ->where('education_id', '>', 1)
            ->where('is_student', 0)
            ->count();
        if ($after11) {
            $section->addText('2. Зачислить в  '.\Auth::user()->college->title.' на базе среднего (полного) общего образования образования:', ['size' => 12], $leftStyle);
            foreach ($groups as $group) {
                $candidates = Candidate::where('group_id', $group->id)
                    ->where('system_id', $this->educationSystemId)
                    ->where('date_took', '0000-00-00')
                    ->where('education_id', '>', 1)
                    ->where('is_student', 0)
                    ->get();
                if ($candidates->count()) {
                    if ($candidates->where('monetary_basis', 1)->count()) {
                        $section->addText('в группу '.$group->title.' на бюджетной основе', ['size' => 12, 'underline' => 'single'], $leftSmStyle);
                        $table = $section->addTable();
                        foreach ($candidates->where('monetary_basis', 1)->all() as $key => $item) {
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
                    if ($candidates->where('monetary_basis', 2)->count()) {
                        $section->addText('в группу '.$group->title.' на платной основе', ['size' => 12, 'underline' => 'single'], $leftSmStyle);
                        $table = $section->addTable();
                        foreach ($candidates->where('monetary_basis', 2)->all() as $key => $item) {
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
                }
            }
        }
        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
        $section->addText('Директор                                                                         _____________', ['size' => 12], $leftStyle);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = str_random().'.docx';
        $objWriter->save(base_path('docs/college_'.\Auth::user()->college_id).'/'.$fileName);
        $protocol = Protocol::where('type', 'order')
            ->where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('approved', 0)
            ->first();
        if (!$protocol) {
            $protocol = Protocol::create([
                'type'              => 'order',
                'order_date'        => datetime('Y-m-d', $date),
                'order_number'      => $number,
                'file'              => $fileName,
                'protocol_date'     => datetime('Y-m-d', $request->get('protocol_date')),
                'enroll_date'       => datetime('Y-m-d', $request->get('enroll_date')),
                'college_id'        => \Auth::user()->college_id,
                'system_id'         => $this->educationSystemId,
            ]);
        } else {
            $protocol->update([
                'order_date'        => datetime('Y-m-d', $date),
                'order_number'      => $number,
                'file'              => $fileName,
                'protocol_date'     => datetime('Y-m-d', $request->get('protocol_date')),
                'enroll_date'       => datetime('Y-m-d', $request->get('enroll_date')),
            ]);
        }

        $protocol->attachCandidate($candidateIds);

        \DB::table('candidates')->whereIn('id', $candidateIds)->update(['order_id' => $protocol->id]);

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="Приказ о зачислении от '.$date.'.docx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.date('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        $objWriter->save('php://output');
    }

    public function approveOrder()
    {
        $protocol = Protocol::where('type', 'order')
            ->where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->orderBy('id', 'desc')
            ->first();
        if ($protocol) {
            $protocol->approved = 1;
            $protocol->save();
            if (!empty($protocol->candidates())) {
                $candidates = $protocol->candidates();
                \DB::table('candidates')->whereIn('id', $candidates)->update(['is_student' => 1]);
                $order = Order::create([
                    'college_id'    => \Auth::user()->college_id,
                    'system_id'     => $this->educationSystemId,
                    'date'          => $protocol->order_date,
                    'number'        => $protocol->order_number,
                    'title'         => 'Приказ о зачислении',
                    'file'          => $protocol->file,
                ]);
                foreach ($candidates as $cn) {
                    $order->candidates()->attach($cn);
                }
            }
        }
        return redirect()->back();
    }
}
