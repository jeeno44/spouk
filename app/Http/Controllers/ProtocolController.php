<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SpecializationGroup;
use Illuminate\Http\Request;

use App\Models\Protocol;
use App\Models\Candidate;
use App\Models\Dictionary;

class ProtocolController extends Controller
{
    public function __construct()
    {
        $this->scripts[] = '/assets/js/orders.js';
        parent::__construct();
    }

    public function index(Request $request)
	{
        if (\Request::ajax()) {
            $orders = Order::where('college_id', \Auth::user()->college_id)
                ->where('college_id', \Auth::user()->college_id)->orderBy('date', 'desc');
            if ($request->has('type') && $request->get('type') != '') {
                $orders->where('title', $request->get('type'));
            }
            if ($request->has('person') && $request->get('person') != 0) {
                $orders->join('candidate_order', 'candidate_order.order_id', '=', 'orders.id')
                    ->where('candidate_order.candidate_id', $request->get('person'));
            }
            $orders = $orders->paginate(20);
            return \Response::json([
                view('protocol.ajaxProtocol', array('orders' => $orders))->render(),
                view('protocol.ajaxProtocolPager', array('orders' => $orders))->render(),
            ]);
        } else {
            $orders = Order::where('college_id', \Auth::user()->college_id)
                ->where('college_id', \Auth::user()->college_id)->orderBy('date', 'desc')->paginate(20);
            $types[''] = 'Не выбран';
            $tts = Order::where('college_id', \Auth::user()->college_id)
                ->where('college_id', \Auth::user()->college_id)->groupBy('title')->pluck('title', 'title');
            foreach ($tts as $tt) {
                $types[$tt] = $tt;
            }
            return view('protocol.index', compact('orders', 'types'));
        }
	}

	public function candidates(Request $request)
    {
        $candidates = Candidate::orderBy('is_invalid1', 'desc')
            ->orderBy('gpa', 'desc')
            ->orderBy('rate', 'desc')
            ->where('certificate_provided', 1)/*->where('form_training', 1)*/
            ->where('system_id', $this->educationSystemId)
            ->where('college_id', \Auth::user()->college_id)
            ->where('date_took', '0000-00-00')
            ->where('is_student', 1)
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%'.$request->get('term').'%')
                    ->orWhere('last_name', 'like', '%'.$request->get('term').'%')
                    ->orWhere('middle_name', 'like', '%'.$request->get('term').'%');
            })
            ->get();

        $answer = [];
        foreach ($candidates as $c) {
            $answer[] = [
                'id'            => $c->id,
                'key'           => $c->id,
                'value'         => $c->first_name.' '.$c->middle_name.' '.$c->last_name,
            ];
        }
        return \Response::json($answer, 200, ['Content-Type: text/html; charset=utf-8']);
    }

	public function download($pid)
    {
        $order = Order::find($pid);
        if (!empty($order->file)) {
            $location = base_path('docs/college_'.\Auth::user()->college_id.'/'.$order->file);
            $ext = pathinfo($location, PATHINFO_EXTENSION);
            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:".filesize($location));
            header("Content-Disposition: attachment; filename=".$order->title.' '.$order->number.'.'.$ext);
            readfile($location);
            die();
        } else {
            $gids = $order->candidates()->groupBy('group_id')->pluck('group_id');
            $groups = SpecializationGroup::whereIn('id', $gids)->get();
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
            $date = date('d.m.Y', strtotime($order->date));
            $section->addText(\Auth::user()->college->title, ['size' => 12], $headStyle);
            $section->addText('ПРИКАЗ'.$order->number, ['size' => 12], $headStyle);
            $section->addText($date.' г.							                   № '.$order->number, ['size' => 12], $baseStyle);
            $section->addText('На основании решения приемной комиссии  '.\Auth::user()->college->title, ['size' => 12], $baseStyle);
            $section->addText('ПРИКАЗЫВАЮ:', ['size' => 12], $baseStyle);
            $section->addText('1. Зачислить в  '.\Auth::user()->college->title.' на базе основного общего образования:', ['size' => 12], $leftStyle);
            foreach ($groups as $group) {
                $candidates = Candidate::where('group_id', $group->id)
                    ->where('system_id', $this->educationSystemId)
                    ->where('date_took', '0000-00-00')
                    ->where('education_id', 1)
                    ->get();
                $section->addText('в группу '.$group->title.' на бюджетной основе', ['size' => 12, 'underline' => 'single'], $leftSmStyle);
                $table = $section->addTable();
                foreach ($candidates as $key => $item) {
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
            $order->file = $fileName;
            $order->save();
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

    }

    function getOrders(Request $request)
    {
        $orders = CandidateOrder::where('college_id', \Auth::user()->college_id)
            ->where('college_id', \Auth::user()->college_id)->orderBy('date', 'desc');
        if ($request->has('type')) {
            $orders->where('title', $request->get('type'));
        }
        if ($request->has('person')) {
            $orders->where('candidate_id', $request->get('person'));
        }
        $orders->paginate(5);
    }

	public function moveProtocol(Request $request)
	{
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $headStyle = 'hStyle';
        $phpWord->addParagraphStyle($headStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 300,]);

        $baseStyle = 'bStyle';
        $phpWord->addParagraphStyle($baseStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spaceAfter' => 300,]);

        $leftStyle = 'lStyle';
        $phpWord->addParagraphStyle($leftStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 300,]);

        $leftSmStyle = 'lStyle';
        $phpWord->addParagraphStyle($leftSmStyle, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 100,]);

        $protocol_date = $request->has('protocol_date') ? $request->input('protocol_date') : date('d.m.Y');
        $number = $request->has('protocol_number') ? $request->input('protocol_number') : '_____';

        $section->addText(\Auth::user()->college->title, ['size' => 12], $headStyle);

        $typeOrder = Dictionary::where('slug', $request->input('actionType'))->first();
        $section->addText($typeOrder->title.' №'.$number, ['size' => 12], $headStyle);

        $section->addText($protocol_date.' г.							                   № '.$number, ['size' => 12], $baseStyle);

        $listStudents = Candidate::whereIn('id', $request->input('candidates'))->get();

        $fancyTableStyleName = 'Список к зачислению';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 20, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::START);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle);

        $table = $section->addTable($fancyTableStyleName);
        foreach ($listStudents as $student) {
        	$table->addRow();
			$table->addCell(2000)->addText($student->last_name);
			$table->addCell(2000)->addText($student->first_name);
			$table->addCell(2000)->addText($student->middle_name);
			$table->addCell(2000)->addText('');

        }

    	$section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
        $section->addText('Директор                                                                         _____________', ['size' => 12], $leftStyle);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = str_random().'.docx';
        $objWriter->save(base_path('docs/college_'.\Auth::user()->college_id).'/'.$fileName);

        $protocol = Protocol::create([
            'type'              => $request->input('actionType'),
            'order_date'        => datetime('Y-m-d', $protocol_date),
            'order_number'      => $number,
            'file'              => $fileName,
            'college_id'        => \Auth::user()->college_id,
            'system_id'         => $this->educationSystemId,
        ]);

        $protocol->attachCandidate($request->input('candidates'));

        return $protocol->id;
	}

	public function preMoveDownload(Request $request)
	{
        $field = 'expelled';
		if ($request->get('type') == 'output') {
		    $field = 'final';
        }
        $students = Candidate::whereIn('id', $request->get('students'))->get();
		switch ($request->get('type')) {
            case 'output':
                $id = $this->outputOrder($students, $request->get('protocol_date'), $request->get('protocol_number'));
                break;
            case 'deduct':
                $id = $this->deductOrder($students, $request->get('protocol_date'), $request->get('protocol_number'));
                break;
            case 'move':
                $id = $this->moveOrder($students, $request->get('protocol_date'), $request->get('protocol_number'));
                break;
            default:
                $id = $this->disposalOrder($students, $request->get('protocol_date'), $request->get('protocol_number'));
        }
        Candidate::whereIn('id', $request->get('students'))->update([$field => 1]);
		return redirect('dec/orders/'.$id);
	}

    protected function outputOrder($students, $date, $number)
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
        $section->addText('Выпустить студентов:', ['size' => 12], $leftStyle);
        $table = $section->addTable();
        foreach ($students as $key => $item) {
            $table->addRow();
            $table->addCell(500)->addText(($key + 1).'.');
            $table->addCell(2000)->addText($item->last_name);
            $table->addCell(2000)->addText($item->first_name);
            $table->addCell(2000)->addText($item->middle_name);
            $table->addCell(2000)->addText('');
            $candidateIds[$item->id] = $item->id;
        }
        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
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
            'title'         => 'Приказ от окончании образовательных отношений',
            'file'          => $fileName,
        ]);
        foreach ($candidateIds as $cn) {
            $order->candidates()->attach($cn);
        }
        return $order->id;
    }

    protected function deductOrder($students, $date, $number)
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
        $section->addText('Отчислить студентов:', ['size' => 12], $leftStyle);
        $table = $section->addTable();
        foreach ($students as $key => $item) {
            $table->addRow();
            $table->addCell(500)->addText(($key + 1).'.');
            $table->addCell(2000)->addText($item->last_name);
            $table->addCell(2000)->addText($item->first_name);
            $table->addCell(2000)->addText($item->middle_name);
            $table->addCell(2000)->addText('');
            $candidateIds[$item->id] = $item->id;
        }
        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
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
            'title'         => 'Приказ об отчислении',
            'file'          => $fileName,
        ]);
        foreach ($candidateIds as $cn) {
            $order->candidates()->attach($cn);
        }
        return $order->id;
    }

    protected function moveOrder($students, $date, $number)
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
        $section->addText('Перевести студентов:', ['size' => 12], $leftStyle);
        $table = $section->addTable();
        foreach ($students as $key => $item) {
            $table->addRow();
            $table->addCell(500)->addText(($key + 1).'.');
            $table->addCell(2000)->addText($item->last_name);
            $table->addCell(2000)->addText($item->first_name);
            $table->addCell(2000)->addText($item->middle_name);
            $table->addCell(2000)->addText('');
            $candidateIds[$item->id] = $item->id;
        }
        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
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
            'title'         => 'Приказ о переводе в другое образовательное учреждение',
            'file'          => $fileName,
        ]);
        foreach ($candidateIds as $cn) {
            $order->candidates()->attach($cn);
        }
        return $order->id;
    }

    protected function disposalOrder($students, $date, $number)
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
        $section->addText('Отчислить студентов:', ['size' => 12], $leftStyle);
        $table = $section->addTable();
        foreach ($students as $key => $item) {
            $table->addRow();
            $table->addCell(500)->addText(($key + 1).'.');
            $table->addCell(2000)->addText($item->last_name);
            $table->addCell(2000)->addText($item->first_name);
            $table->addCell(2000)->addText($item->middle_name);
            $table->addCell(2000)->addText('');
            $candidateIds[$item->id] = $item->id;
        }
        $section->addText('', ['size' => 12, 'bold' => true], $leftStyle);
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
            'title'         => 'Приказ о выбытии из образовательного учреждения',
            'file'          => $fileName,
        ]);
        foreach ($candidateIds as $cn) {
            $order->candidates()->attach($cn);
        }
        return $order->id;
    }

	public function moveDownload($protocol_id)
	{
		$protocol = Protocol::find($protocol_id);

        if (!$protocol || $protocol->college_id != \Auth::user()->college_id) {
            abort(403, 'Forbidden');
        }

        $file = base_path('docs/college_'.$protocol->college_id.'/'.$protocol->file);

        if (!file_exists($file) || !is_file($file)) {
            abort(404);
        }

        $titleDocument = $protocol->dicType->title. ' от '.datetime('d.m.Y', $protocol->order_date);
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="'.$titleDocument.'.docx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.date('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');

        readfile($file);
        exit;
	}
}
