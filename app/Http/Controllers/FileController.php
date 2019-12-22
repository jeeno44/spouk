<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\CandidateDoc;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\School;
use App\Models\Specialization;
use App\Models\Subdivision;
use App\Models\User;
use App\Models\College;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor as Template;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;

use App\Http\Requests;

class FileController extends Controller
{
    public function getDoc($id)
    {
        $doc = CandidateDoc::find($id);
        if (!$doc || $doc->college_id != \Auth::user()->college_id) {
            abort(403, 'Forbidden');
        }
        $file = base_path('docs/college_'.$doc->college_id.'/'.$doc->filename);
        if (!file_exists($file) || !is_file($file)) {
            abort(404);
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }

    /**
     * Генерируем документ и отдаем на скачку
     *
     * @param  int $id
     * @return string
     * @access public
     */

    public function generateStatement($id)
    {
        $candidate = \App\Models\Candidate::find($id);
        if ($candidate->is_russian) {
            $templateId = config('docs.russian_statement_template_id');
        } else {
            $templateId = config('docs.not_russian_statement_template_id');
        }

        $xmlParts = '';
        $xmlParts .= '<item name="reg_number">' . $candidate->reg_number . '</item>';

        $college  = College::find($candidate->college_id);
        $users    = User::where('college_id', $college->id)->get();

        foreach ($users as $user) {
            if ($user->hasRole('principal')) {
                $dir_name = $user->last_name . ' ' . $user->first_name . ' ' . $user->middle_name;
                $xmlParts .= '<item name="dir_name">' . $dir_name . '</item>';
                break;
            }
        }
        $xmlParts .= '<item name="college_name">' . $college->title . '</item>';
        $xmlParts .= '<item name="fio">' . $candidate->last_name . ' ' . $candidate->first_name . ' ' . $candidate->middle_name . '</item>';
        $xmlParts .= '<item name="address">' . (string) $candidate->law_address . '</item>';
        if ($candidate->school != null) {
            $school = $candidate->school->title;
        } else {
            $school = '';
        }
        $xmlParts .= '<item name="school_name">' . $school . '</item>';
        $xmlParts .= '<item name="region">' . $candidate->region->title . '</item>';
        $xmlParts .= '<item name="city">' . $college->title . '</item>';
        $xmlParts .= '<item name="spec_code">' . (!empty($candidate->spec->code) ? $candidate->spec->code : '') . '</item>';
        $xmlParts .= '<item name="spec_name">' . (!empty($candidate->spec->title) ? $candidate->spec->title : '') . '</item>';
        $xmlParts .= '<item name="form_training">' . $candidate->formTraining->title . '</item>';
        $xmlParts .= '<item name="monetary_basis">' . $candidate->monetaryBasis->title . '</item>';

        if ( $candidate->birth_date != '0000-00-00' ) {
            $xmlParts .= '<item name="birthday">' . date('d.m.Y', strtotime($candidate->birth_date)) . '</item>';
        } else {
            $xmlParts .= '<item name="birthday"></item>';
        }

        if ( $candidate->date_of_filing != '0000-00-00' ) {
            $xmlParts .= '<item name="date">' . date('d.m.Y', strtotime($candidate->date_of_filing)) . '</item>';
        } else {
            $xmlParts .= '<item name="date"></item>';
        }

        if ( $candidate->certificate_issued_at != '0000-00-00' ) {
            $xmlParts .= '<item name="attestat_date">' . date('d.m.Y', strtotime($candidate->certificate_issued_at)) . '</item>';
        } else {
            $xmlParts .= '<item name="attestat_date"></item>';
        }

        $xmlParts .= '<item name="formobaz">' . (($candidate->form_training > 3) ? 'повторно' : 'впервые') . '</item>';

        if ($candidate->is_russian) {
            $passport = explode(' ', $candidate->passport_number);
            $xmlParts .= '<item name="pas_ser">' . (!empty($passport[0]) ? $passport[0] : '') . '</item>';
            $xmlParts .= '<item name="pas_nomer">' . (!empty($passport[1]) ? $passport[1] : '') . '</item>';
            $xmlParts .= '<item name="passport_provided">' .  $candidate->passport_provided_place . '</item>';

            if ( $candidate->passport_provided_at != '0000-00-00' ) {
                $xmlParts .= '<item name="pass_date">' . date('d.m.Y', strtotime($candidate->passport_provided_at)) . '</item>';
            } else {
                $xmlParts .= '<item name="pass_date"></item>';
            }

        } else {
            $xmlParts .= '<item name="pas_ser">' .  $candidate->international_passport . '</item>';
        }

        $xmlParts .= '<item name="education_type">' .  $candidate->educationType->title . '</item>';
        $xmlParts .= '<item name="attestat">' . $candidate->certificate . '</item>';
        $xmlParts .= '<item name="phone">' . (!empty($candidate->phones[0]->phone) ? $candidate->phones[0]->phone : '') . '</item>';

        $headers = ['Content-Type: application/json', 'Accept: application/json', 'Authorization: Bearer ' . config('docs.token')];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('docs.api_url_create'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $xml = '<?xml version="1.0" encoding="UTF-8"?><document><variables>' . $xmlParts . '</variables></document>';
        $docName = 'Заявление о зачислении от ' . $candidate->last_name . ' ' . $candidate->first_name . ' ' . $candidate->middle_name;
        $post_data = [
            'template_id' => $templateId,
            'xml'         => $xml,
            'callback_url'  => route('callback.statement'),
            'name'  => $docName,
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($ch);
        curl_close($ch);
        $document_id = json_decode((string) $output, true)['document_id'];
        if (!empty($document_id)) {
            \App\Models\Document::create([
                'title' => $docName,
                'out_id' => $document_id,
                'document_type_id' => DocumentType::where('template_id', $templateId)->first()->id,
                'candidate_id' => $id,
            ]);
        }
        return redirect()->back()->with('status', 'Документ поставлен в очередь!');
    }

    public function callbackStatement(Request $request)
    {
        $doc = Document::where('out_id', $request->get('document_id'))->first();
        if ($doc) {
            $doc->docx_link = $request->get('docx');
            $doc->pdf_link = $request->get('pdf');
            $doc->save();
        }
    }

    public function excelRate(Request $request)
    {
        $spec = Specialization::find($request->get('spec_id'));
        if (!$spec || $spec->college_id != \Auth::user()->college_id) {
            abort(404);
        }
        $users = Candidate::where('college_id', \Auth::user()->college_id)->where('specialization_id', $request->get('spec_id'))
            ->where('system_id', $this->educationSystemId)->where('is_student', 0)
            ->orderBy('is_invalid1', 'desc')->orderBy('gpa', 'desc')->orderBy('rate', 'desc')->get();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Контингент СПО")
            ->setLastModifiedBy("Контингент СПО")
            ->setTitle("Рейтинг по специальностям / профессиям")
            ->setSubject("Рейтинг по специальностям / профессиям")
            ->setDescription("Рейтинг по специальностям / профессиям");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Рег. номер');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'ФИО');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Дата рождения');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Телефон');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Рейтинг');
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Специальности');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Предоставил оригинал аттестата');
        $i = 2;
        foreach($users as $k => $item) {
            $phone = $specs = '';
            if (!empty($item->phones()->first()->phone)) {
                $phone = $item->phones()->first()->phone;
            }
            if(!empty($item->spec->title)) {
                $specs = $item->spec->code.' - '.$item->spec->title;
            }
            if($item->specializations->count() > 0) {
                $specs .= ' и '.$item->specializations->count().' '.trans_choice('phrases.dops', $item->specializations->count());
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $item->reg_number);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $item->last_name. ' '. $item->first_name. ' '. $item->middle_name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, date('d.m.Y', strtotime($item->birth_date)));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $phone);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $item->gpa.' ('.$item->rate.')');
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, $specs);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, $item->certificate_provided ? 'Да' : 'Нет');
            $i++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Рейтинг по специальности ' . $spec->title . '.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.date('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        return redirect()->back();
    }

    public function excelList()
    {
        $users = Candidate::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)->latest()->get();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Контингент СПО")
            ->setLastModifiedBy("Контингент СПО")
            ->setTitle("Рейтинг по специальностям / профессиям")
            ->setSubject("Рейтинг по специальностям / профессиям")
            ->setDescription("Рейтинг по специальностям / профессиям");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Рег. номер');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Дата приема заявления');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Специальность');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'ФИО');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Предыдущее место учебы');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Год окончания');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Примечание');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Перечень поданных документов');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Адрес проживания');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Дата подачи документов');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Расписка');
        $i = 2;
        foreach($users as $k => $item) {
            $phone = $specs = $school = $docs = '';
            $docs .= "Заявление\n";
            if (!empty($item->phones()->first()->phone)) {
                $phone = $item->phones()->first()->phone;
            }
            if(!empty($item->spec->title)) {
                $specs = $item->spec->code.' - '.$item->spec->title;
            }
            if (!empty($item->school_id)) {
                $schoolObj = School::find($item->school_id);
                if ($schoolObj) {
                    $school = $schoolObj->title."\n г.".$schoolObj->city->title;
                }
            }
            if ($item->certificate_provided) {
                $docs .= "Аттестат №".$item->certificate;
            }
            if ($item->health_certificate_provided) {
                $docs .= "\nМедицинская справка";
            }
            if ($item->vaccinations_provided) {
                $docs .= "\nПрививочный сертификат";
            }
            if ($item->certificate_25u_provided) {
                $docs .= "\nСправка025-Ю";
            }
            if ($item->photos_provided) {
                $docs .= "\n4 фотографии";
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $item->reg_number);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, date('d.m.Y', strtotime($item->created_at)));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $specs);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $item->last_name. ' '. $item->first_name. ''. $item->middle_name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $school);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, $item->graduatedYear);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $item->is_invalid);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i, $docs);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, $item->region->title.", \n".$item->city->title.", \n".$item->address.", \n".$phone);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, date('d.m.Y', strtotime($item->date_of_filing)));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, '');
            $i++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Журнал регистрации.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.date('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        return redirect()->back();
    }

    public function excelKcp()
    {
        $subDivs = Subdivision::where('college_id', \Auth::user()->college_id)->where('system_id', $this->educationSystemId)->get();
        $college = College::find(\Auth::user()->college_id);
        $candidates = Candidate::where('college_id', $college->id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')
            ->where('is_student', 0)
            ->get();
        if (!$college) {
            abort(404);
        }
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Контингент СПО")
            ->setLastModifiedBy("Контингент СПО")
            ->setTitle("Информация по выполнению контрольных цифр приёма обучающихся на новый 2016/2017учебный год по состоянию на ".date('d.m.Y'))
            ->setSubject("Информация по выполнению контрольных цифр приёма обучающихся на новый 2016/2017учебный год по состоянию на ".date('d.m.Y'))
            ->setDescription("Информация по выполнению контрольных цифр приёма обучающихся на новый 2016/2017учебный год по состоянию на ".date('d.m.Y'));
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(55);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Наименование учреждений');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Наименования профессий / специальностей');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Форма обучения');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Количество бюджетных мест по приказу КЦП');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Подано заявлений');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Конкурс (соотношение поданных заявлений к бюджетным местам)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Девушек');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Юношей');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Граждане РФ');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Иностранные граждане');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Являются сиротами');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Являются инвалидами');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'г. Москва');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'Московская область');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'Иной регион проживания');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'Целевой прием');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', $candidates->where('gender', 'female')->count());
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', $candidates->where('gender', 'male')->count());
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', $candidates->where('is_russian', 1)->count());
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', $candidates->where('is_russian', 0)->count());
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', $candidates->where('fatherless', 1)->count());
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', $candidates->where('is_invalid1', 1)->count());
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', $candidates->where('city_id', 1)->count());
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', $candidates->where('region_id', 1)->where('city_id', '!=', 1)->count());
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', $candidates->where('region_id', '!=', 1)->count());
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', $candidates->where('monetary_basis', 3)->count());

        $objPHPExcel->getActiveSheet()->mergeCells('D2:F2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'Контрольные цифры приема по программам подготовки квалифицированных рабочих');
        $i = 3;
        $subSpecsCount = Specialization::whereIn('subdivision_id', $subDivs->pluck('id'))->where('system_id', $this->educationSystemId)->count();
        if (count($subDivs) > 0 && $subSpecsCount > 0) {
            foreach ($subDivs as $subDiv) {
                $specs = Specialization::where('subdivision_id', $subDiv->id)->where('system_id', $this->educationSystemId)->get();
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':F'.$i);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $subDiv->title);
                $i++;
                $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow('A'.$i.':A'.($i + count($specs) * 2));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, \Auth::user()->college->title);
                foreach ($specs as $spec) {
                    $och = Candidate::where('specialization_id', $spec->id)->where('form_training', 1)->where('system_id', $this->educationSystemId)->where('is_student', 0)->count();
                    $zaoch = Candidate::where('specialization_id', $spec->id)->where('form_training', 2)->where('system_id', $this->educationSystemId)->where('is_student', 0)->count();
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $spec->title);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i + 1), $spec->title);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, 'очная');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i + 1), 'заочная');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $spec->kcp);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i + 1), $spec->kcp);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $och);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i + 1), $zaoch);
                    if ($spec->kcp > 0) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, round($och/$spec->kcp, 2));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i + 1), round($zaoch/$spec->kcp, 2));
                    }
                    $i = $i + 2;
                }
            }
        } else {
            $specs = Specialization::where('college_id', \Auth::user()->college_id)->where('system_id', $this->educationSystemId)->get();
            $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow('A'.$i.':A'.($i + count($specs) * 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, \Auth::user()->college->title);
            foreach ($specs as $spec) {
                $och = Candidate::where('specialization_id', $spec->id)->where('form_training', 1)->where('system_id', $this->educationSystemId)->where('is_student', 0)->count();
                $zaoch = Candidate::where('specialization_id', $spec->id)->where('form_training', 2)->where('system_id', $this->educationSystemId)->where('is_student', 0)->count();
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $spec->title);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i + 1), $spec->title);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, 'очная');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i + 1), 'заочная');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $spec->kcp);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i + 1), $spec->kcp);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $och);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i + 1), $zaoch);
                if ($spec->kcp > 0) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, round($och/$spec->kcp, 2));
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i + 1), round($zaoch/$spec->kcp, 2));
                }
                $i = $i + 2;
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Информация по выполнению контрольных цифр приёма обучающихся на новый 2016/2017учебный год по состоянию на '.date('d.m.Y').'.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header ('Last-Modified: '.date('D, d M Y H:i:s').' GMT');
        header ('Cache-Control: cache, must-revalidate');
        header ('Pragma: public');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        return redirect()->back();
    }
}
