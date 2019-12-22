<?php

namespace App\Http\Controllers;

use App\Models\Analyst;

class AnalystController extends Controller
{
    public function statistics()
    {
        return view('analyst.statistics')->with('statistics', Analyst::getStatistics());
    }

    public function dynamics()
    {
        return view('analyst.dynamics');
    }

    public function getDynamicsToChart()
	{
        $data = array();

        $data['cols'][] = array('label' => 'Дни', 'type' => 'string' );
        $data['cols'][] = array('label' => 'Абитуриент', 'type' => 'number');

        $i = 0;
        $list_object = Analyst::getDynamics();
        foreach ($list_object as $object)
        {
            $data['rows'][$i]['c'][0]['v'] = $object->created_at;
            $data['rows'][$i]['c'][1]['v'] = $object->total;
            $i++;
        }

        return \Response::json($data);
	}
}
