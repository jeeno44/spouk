<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Subdivision;
use Illuminate\Console\Command;

class Moskovia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moskovia:do';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        for ($i = 25; $i < 30; $i++) {
            $collegeId = 32;
            $subdivID = $i;
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load(base_path('resources/datas/32/'.$subdivID.'.xls'));
            $sDiv = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
            $subdiv = Subdivision::find($subdivID);
            $subdiv->update([
                'inn' => (int)$sDiv[2]['C'],
                'ogrn' => (int)$sDiv[3]['C'],
                'type' => $sDiv[4]['C'],
                'full_title' => $sDiv[5]['C'],
                //'title' => $sDiv[6]['C'],
                'form' => $sDiv[7]['C'],
                'parent_inn' => (int)$sDiv[8]['C'],
                'views' => $sDiv[9]['C'],
                'okopf' => (int)$sDiv[10]['C'],
                'okfsf' => (int)$sDiv[11]['C'],
                'okved' => (int)$sDiv[12]['C'],
                'strukture' => $sDiv[13]['C'],
                'make_date' => $sDiv[14]['C'],
                'uchred' => $sDiv[15]['C'],
                'law_address' => $sDiv[16]['C'],
                'post_address' => $sDiv[17]['C'],
                'city' => $sDiv[18]['C'],
                'okpo' => (int)$sDiv[21]['C'],
                'oktmo' => (int)$sDiv[22]['C'],
                'okato' => (int)$sDiv[23]['C'],
                'actual_date' => $sDiv[24]['C'],
                'status' => $sDiv[25]['C'],
                'phone' => $sDiv[26]['C'],
                'fax' => $sDiv[27]['C'],
                'email' => $sDiv[28]['C'],
                'site' => $sDiv[29]['C'],
                'licence_number' => (int)$sDiv[30]['C'],
                'licence_date' => $sDiv[31]['C'],
                'licence_serie' => $sDiv[32]['C'],
                'licence_date_finish' => $sDiv[33]['C'],
                'reg_number' => (int)$sDiv[34]['C'],
                'blank_number' => $sDiv[35]['C'],
                'blank_date' => $sDiv[36]['C'],
                'blank_finish' => $sDiv[37]['C'],
            ]);

            $groups = $objPHPExcel->getSheet(1)->toArray(null,true,true,true);
            foreach ($groups as $key => $group) {
                if ($key >= 4) {
                    $spekName = trim($group['H']);
                    if (!empty($spekName)) {
                        $spek = \App\Models\Specialization::where('title', $spekName)->where('college_id', $collegeId)->first();
                        if (!$spek) {
                            $spek = \App\Models\Specialization::create([
                                'title'   => trim($group['H']),
                                'code'    => $group['G'],
                                'kcp'     => (int)$group['E'],
                                'college_id'   => $collegeId,
                                'system_id' => 1,
                                'subdivision_id' => $subdivID
                            ]);
                        }
                    } else {
                        $spekName = trim($group['B']);
                        $spek = \App\Models\Specialization::where('title', $spekName)->where('college_id', $collegeId)->first();
                        if (!$spek) {
                            $spek = \App\Models\Specialization::create([
                                'title'   => trim($group['B']),
                                'code'    => $group['B'],
                                'kcp'     => (int)$group['E'],
                                'college_id'   => $collegeId,
                                'system_id' => 1,
                                'subdivision_id' => $subdivID
                            ]);
                        }
                    }
                    $data = [
                        'year'  => (int)$group['A'],
                        'specialization_id' => $spek->id,
                        'title'   => trim($group['B']),
                        'free_places'     => (int)$group['E'],
                        'non_free_places'     => (int)$group['E'],
                        'code'   => $group['B'],
                        'number_course' => ((int)$group['C'] > 3) ? $group['C']: 3,
                        'course_id' => 66 + (int)$group['C'],
                        'semester_id' => 1,
                    ];
                    $gg = \App\Models\SpecializationGroup::where('title', trim($group['B']))
                        ->where('specialization_id', $spek->id)->first();
                    if (!$gg) {
                        \App\Models\SpecializationGroup::create($data);
                    }
                }
            }
            $students = $objPHPExcel->getSheet(2)->toArray(null,true,true,true);
            foreach ($students as $key => $student) {
                if ($key > 3) {
                    $candidate = \App\Models\Candidate::where('first_name', $student['B'])
                        ->where('last_name', $student['A'])
                        ->where('middle_name', $student['C'])
                        ->where('college_id', $collegeId)->first();
                    if (!$candidate) {
                        $gender = 'male';
                        if ($student['E'] == 'Женский') {
                            $gender = 'female';
                        }
                        $candidate = \App\Models\Candidate::create([
                            'last_name' => !empty($student['A']) ? $student['A'] : '',
                            'first_name' => !empty($student['B']) ? $student['B'] : '',
                            'middle_name' => !empty($student['C']) ? $student['C'] : '',
                            'gender' => $gender,
                            'reg_number' => rand(1000, 9000),
                            'birth_date' => date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($student['D'])),
                            'form_training' => 1,
                            'monetary_basis' => 1,
                            'email' => !empty($student['K']) ? $student['K'] : '',
                            'education_id' => 1,
                            'certificate_provided' => 1,
                            'pension_certificate' => !empty($student['F']) ? $student['F'] : '',
                            'photos_provided' => 1,
                            'vaccinations_provided' => 1,
                            'health_certificate_provided' => 1,
                            'certificate_25u_provided' => 1,
                            'passport_number' => (int)$student['M'].' '.(int)$student['N'],
                            'college_id' => $collegeId,
                            'school_id' => null,
                            'is_student' => 1,
                            'region_id' => 1,
                            'city_id' => 35,
                            'subdivision_id' => $subdivID,
                            'is_russian' => 1,
                            'system_id' => 1,
                            'enrollment_reason_id' => 5
                        ]);
                    }
                }
            }
            $sgs = $objPHPExcel->getSheet(3)->toArray(null,true,true,true);
            $specks = \App\Models\Specialization::where('college_id', $collegeId)->where('subdivision_id', $subdivID)->pluck('id');
            foreach ($sgs as $key => $sg) {
                if ($key > 3) {
                    $cand = \App\Models\Candidate::where('first_name', $sg['B'])
                        ->where('last_name', $sg['A'])
                        ->where('middle_name', $sg['C'])
                        ->where('college_id', $collegeId)->first();
                    $grou =  \App\Models\SpecializationGroup::where('title',  trim($sg['E']))->whereIn('specialization_id', $specks)->first();
                    if ($cand && $grou) {
                        $cand->group_id = $grou->id;
                        $cand->specialization_id = $grou->specialization_id;
                        $cand->save();
                        if (!empty($sg['H'])) {
                            $order = Order::where('college_id', $collegeId)->where('number',trim($sg['H']))->first();
                            if (!$order) {
                                $order = Order::create([
                                    'college_id' => $collegeId,
                                    'title' => 'Приказ о зачислении',
                                    'system_id' => 1,
                                    'date' => date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($sg['I'])),
                                    'number' => trim($sg['H'])
                                ]);
                            }
                            $order->candidates()->attach($cand->id);
                        }
                    }
                }
            }
        }
    }
}
