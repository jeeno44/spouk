<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Region;
use App\Models\Specialization;
use App\Models\SpecializationGroup;
use App\Models\Subdivision;
use Illuminate\Http\Request;

use App\Http\Requests;
use PhpOffice\PhpWord\TemplateProcessor as Template;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;

class ExportController extends Controller
{
    public function spo()
    {
        $template  = new Template(base_path('docs/templates/spo-1.docx'));
        $template->setValue('current_year', date('Y'));
        $template->setValue('next_year', date('Y', strtotime('+1 year')));
        $template->setValue('college_name', \Auth::user()->college->title);
        $template->setValue('college_address', \Auth::user()->college->address);
        $fileName = 'spo-1-'.\Auth::user()->college_id.'-'.date('d.m.Y').'.docx';
        $template->saveAs(base_path('docs/tmp/'.$fileName));

        header('Content-Description: File Transfer');
        header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document;');
        header('Content-Disposition: attachment; filename="'.basename(base_path('docs/tmp/'.$fileName)).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize(base_path('docs/tmp/'.$fileName)));
        readfile(base_path('docs/tmp/'.$fileName));

        exit;
    }

    public function allAbirs()
    {
        $candidates = Candidate::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')
            ->where('is_student', 0)
            ->get();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Контингент СПО")
            ->setLastModifiedBy("Контингент СПО")
            ->setTitle("Выгрузка всех абитуриентов")
            ->setSubject("Выгрузка всех абитуриентов")
            ->setDescription("Выгрузка всех абитуриентов");
        $lastRowNumber = count($candidates) + 1;

        $objPHPExcel->getActiveSheet()->getStyle("A1:P1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A1:P{$lastRowNumber}")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A2:P{$lastRowNumber}")->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("A1:P{$lastRowNumber}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("A1:P1")->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => 'DDDDDD'
            ]
        ));

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Рег. номер')
            ->setCellValue('B1', 'ФИО')
            ->setCellValue('C1', 'Пол')
            ->setCellValue('D1', 'Дата рождения')
            ->setCellValue('E1', 'Средний балл')
            ->setCellValue('F1', 'Форма обучения')
            ->setCellValue('G1', 'Вид финансирования')
            ->setCellValue('H1', 'Окончил(а) классов')
            ->setCellValue('I1', 'Поступает в')
            ->setCellValue('J1', 'Телефон')
            ->setCellValue('K1', 'E-mail')
            ->setCellValue('L1', 'Дата подачи документов')
            ->setCellValue('M1', 'Основная специальность')
            ->setCellValue('N1', 'Является сиротой')
            ->setCellValue('O1', 'Является индвалидом')
            ->setCellValue('P1', 'Причина инвалидности');

        foreach ($candidates as $key => $candidate) {
            $key += 2;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$key, $candidate->reg_number)
                ->setCellValue('B'.$key, $candidate->last_name . ' ' . $candidate->first_name . ' ' . $candidate->middle_name)
                ->setCellValue('C'.$key, (($candidate->gender == 'male') ? 'Муж.' : 'Жен.'))
                ->setCellValue('D'.$key, date('d.m.Y', strtotime($candidate->birth_date)))
                ->setCellValue('E'.$key, $candidate->gpa)
                ->setCellValue('F'.$key, (!empty($candidate->formTraining) ? $candidate->formTraining->title : ''))
                ->setCellValue('G'.$key, (!empty($candidate->monetaryBasis) ? $candidate->monetaryBasis->title : ''))
                ->setCellValue('H'.$key, $candidate->graduatedClass)
                ->setCellValue('I'.$key, $candidate->admissionYear)
                ->setCellValue('J'.$key, (!empty($candidate->phones()->first()) ? $candidate->phones()->first()->phone : ''))
                ->setCellValue('K'.$key, $candidate->email)
                ->setCellValue('L'.$key, (($candidate->date_of_filing != '0000-00-00') ? date('d.m.Y', strtotime($candidate->date_of_filing)): ''))
                ->setCellValue('M'.$key, (!empty($candidate->spec->title) ? $candidate->spec->title : ''))
                ->setCellValue('N'.$key, (($candidate->fatherless == 1) ? 'Да' : 'Нет'))
                ->setCellValue('O'.$key, (($candidate->is_invalid1 == 1) ? 'Да' : 'Нет'))
                ->setCellValue('P'.$key, $candidate->is_invalid);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Выгрузка всех абитуриентов по состоянию на '.date('d.m.Y').'.xls"');
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

    public function regionAbirs()
    {
        $regions = Region::all();
        $candidates = Candidate::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('date_took', '0000-00-00')
            ->where('is_student', 0)
            ->get();
        $subDivs = Subdivision::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->get();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Контингент СПО")
            ->setLastModifiedBy("Контингент СПО")
            ->setTitle("Региональное распределение абитуриентов")
            ->setSubject("Региональное распределение абитуриентов")
            ->setDescription("Региональное распределение абитуриентов");
        $lastRowNumber = count($regions) + 1;

        if (count($subDivs)) {
            $arrSubDivs = [];
            $key = 2;
            foreach ($subDivs as $subDiv) {
                $arrSubDivs[toNum($key)] = $subDiv;
                $key++;
            }
            $allKey = toNum($key);
            $objPHPExcel->getActiveSheet()->getStyle("A1:{$allKey}1")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A1:{$allKey}{$lastRowNumber}")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle("A2:{$allKey}{$lastRowNumber}")->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("A1:{$allKey}{$lastRowNumber}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("A1:{$allKey}1")->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => [
                    'rgb' => 'DDDDDD'
                ]
            ));
            $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(25);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Регион');
            foreach ($arrSubDivs as $letter => $sd) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter . '1', $sd->title);
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($allKey . '1', 'Всего');
            foreach ($regions as $key => $region) {
                $key += 2;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$key, $region->title)
                    ->setCellValue($allKey.$key, $candidates->where('region_id', $region->id)->count());
                foreach ($arrSubDivs as $letter => $sd) {
                    $specs = Specialization::where('subdivision_id', $sd->id)->pluck('id')->toArray();
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter.$key, $candidates->whereIn('specialization_id', $specs)->where('region_id', $region->id)->count());
                }
            }
        } else {
            $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A1:B{$lastRowNumber}")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle("A2:B{$lastRowNumber}")->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("A1:B{$lastRowNumber}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => [
                    'rgb' => 'DDDDDD'
                ]
            ));
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Регион')
                ->setCellValue('B1', 'Кол-во абитуриентов');
            foreach ($regions as $key => $region) {
                $key += 2;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$key, $region->title)
                    ->setCellValue('B'.$key, $candidates->where('region_id', $region->id)->count());
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Региональное распределение абитуриентов по состоянию на '.date('d.m.Y').'.xls"');
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

    public function journal($type = 'rec-book')
    {
        $docName = (($type == 'rec-book') ? 'Журнал выдачи зачетных книжек' : 'Журнал выдачи студенческих билетов');
        $specs = Specialization::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->pluck('id')
            ->toArray();
        $groups = SpecializationGroup::whereIn('specialization_id', $specs)->where('number_course', 1)->where('semester_id', 1)->pluck('id')
            ->toArray();
        $candidates = Candidate::where('college_id', \Auth::user()->college_id)
            ->where('is_student', 1)
            ->where('expelled', 0)
            ->whereIn('group_id', $groups)
            ->get();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Контингент СПО")
            ->setLastModifiedBy("Контингент СПО")
            ->setTitle($docName)
            ->setSubject($docName)
            ->setDescription($docName);
        $lastRowNumber = count($candidates) + 1;

        $objPHPExcel->getActiveSheet()->getStyle("A1:E1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A1:E{$lastRowNumber}")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A2:E{$lastRowNumber}")->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("A1:E{$lastRowNumber}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("A2:E{$lastRowNumber}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A1:E1")->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => [
                'rgb' => 'DDDDDD'
            ]
        ));

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Поименный номер')
            ->setCellValue('B1', 'Специальность')
            ->setCellValue('C1', 'ФИО')
            ->setCellValue('D1', 'Дата рождения')
            ->setCellValue('E1', 'Подпись');

        foreach ($candidates as $key => $candidate) {
            $key += 2;
            $objPHPExcel->getActiveSheet()->getRowDimension($key)->setRowHeight(30);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$key, $candidate->name_number)
                ->setCellValue('B'.$key, (!empty($candidate->spec->title) ? $candidate->spec->title : ''))
                ->setCellValue('C'.$key, $candidate->last_name . ' ' . $candidate->first_name . ' ' . $candidate->middle_name)
                ->setCellValue('D'.$key, date('d.m.Y', strtotime($candidate->birth_date)))
                ->setCellValue('E'.$key, '');
        }


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $docName . ' по состоянию на '.date('d.m.Y').'.xls"');
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
