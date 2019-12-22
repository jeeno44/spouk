<?php

namespace App\Http\Controllers;

use App\Models\College,
    App\Models\CandidateDoc,
    App\Models\Candidate,
    App\Models\Specialization,
    Illuminate\Http\Request,
    App\Http\Requests,
    PhpOffice\PhpWord\PhpWord,
    PhpOffice\PhpWord\TemplateProcessor as Template,
    PhpOffice\PhpWord\IOFactory;
use App\Models\SpecializationGroup;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\TemplateProcessor;

class FormationOfOrdersController extends Controller
{
    private $actions = [
      1     => array('name' => 'Сформировать протокол работы приемной комиссии', 'action' => '/candidates/filterSpecialization/protocol/download'),
      2     => array('name' => 'Сформировать Приказ о зачислении', 'action' => '/candidates/filterSpecialization/generateOrderInstall/download')
    ];
    
    /**
     * Генерация приказа о зачисление
     * 
     * @param  Request $request
     * @return array
     * @access public
     */
    
    public function generateOrderInstall(Request $request)
    {
        $college = College::find(\Auth::user()->college_id);
        $spec    = Specialization::find($request->get('specID'));
        
        $monthes = array(
            1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
            5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
            9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
        );
        
        $date   = date('d.m.Y');
        $dd_str = date('« d »', strtotime($date)) . ' ' .$monthes[(date('n', strtotime($date)))] . ' ' . date('Y', strtotime($date));
        
        //$obPHPWord = new PHPWord();
        $template  = new TemplateProcessor(base_path('docs/templates/prikaz.docx'));
        $template->setValue('college_name', $college->title);
        //$template->saveAs(base_path('docs/tmp/'));
        header('Content-Description: File Transfer');
        header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document;');
        header('Content-Disposition: attachment; filename="'.basename(base_path('docs/tmp/'.$fileName)).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize(base_path('docs/tmp/'.$fileName)));
        $template->save();
    }
    
    /**
     * Выводим список абиров по нужной специализиации
     * 
     * @param  Request $request
     * @return string [VIEW]
     * @access public
     */
    
    public function showCandidates(Request $request)
    {
        $actionID = $this->actions[$request->get('actionID')];
        $buildQuery = Candidate::where('college_id', \Auth::user()->college_id)->where('system_id', $this->educationSystemId);
        $spec = Specialization::find($request->get('specID'));
        $buildQuery->where('specialization_id', $spec->id);
        $buildQuery->select('*', \DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) as fio'),
                    \DB::raw('date_format(birth_date, "%d.%m.%Y") as birth_date'),
                    \DB::raw('TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age'))
                    ->orderBy('is_invalid1', 'desc')->orderBy('gpa', 'desc')->orderBy('rate', 'desc');
        
        $candidates = $buildQuery->paginate(20);
        
        $specs = Specialization::where('college_id', \Auth::user()->college_id)->orderBy('title')->orderBy('code')->get();
        return view('candidates.filter', compact('candidates', 'specs', 'actionID'));
    }
    
    /**
     * Протокол работы приемной комиссии
     * 
     * @param  Request $request
     * @return mixed
     * @access public
     */
    
    public function generateProtocolCommission(Request $request, $spec)
    {
        $college = College::find(\Auth::user()->college_id);
        $spec    = Specialization::find($spec);
        
        $template  = new TemplateProcessor(base_path('docs/templates/protocol_commission_table.docx'));
        $template->setValue('college_name', $college->title);
        
        $monthes = array(
            1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
            5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
            9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
        );
        
        $date   = date('d.m.Y');
        $dd_str = date('d', strtotime($date)) . ' ' .$monthes[(date('n', strtotime($date)))] . ' ' . date('Y', strtotime($date));
        $template->setValue('date_string', $dd_str);
        $template->setValue('code', $spec->code);
        $template->setValue('spec_name', $spec->title);
        
        $candidates   = Candidate::where('specialization_id', $spec->id)
            ->where('system_id', $this->educationSystemId)
            ->orderBy('is_invalid1', 'desc')->orderBy('gpa', 'desc')
            ->orderBy('rate', 'desc')->get();
        $ccCandidates = $candidates->count();
        $iteration    = 1;
        $template->cloneRow('num', $ccCandidates);
        
        foreach ( $candidates as $candidate )
        {
            $template->setValue('num#'.$iteration, $iteration);
            $template->setValue('lname#'.$iteration, $candidate->last_name);
            $template->setValue('fname#'.$iteration, $candidate->first_name);
            $template->setValue('mname#'.$iteration, $candidate->middle_name);
            $template->setValue('ball#'.$iteration, $candidate->gpa.'('.$candidate->rate.')');
            $template->setValue('itogi#'.$iteration, ' ');
            
            $iteration++;
        }
        
        $temp_file = str_random();
        $template->saveAs(base_path('docs/tmp/'.$temp_file));
 
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="ПРОТОКОЛ ЗАСЕДАНИЯ ПРИЕМНОЙ КОМИССИИ от '.$dd_str.' '.$spec->title.'.docx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Length: ' . filesize(base_path('docs/tmp/'.$temp_file)));
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        
        readfile(base_path('docs/tmp/'.$temp_file));
        unlink(base_path('docs/tmp/'.$temp_file));
    }
}
