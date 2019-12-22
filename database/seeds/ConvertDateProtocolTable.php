<?php

use Illuminate\Database\Seeder;

class ConvertDateProtocolTable extends Seeder
{
    private $isSave = false;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listProtocol = \App\Models\Protocol::get();
        foreach ($listProtocol as $protocol)
		{
			if ($this->isCorrect($protocol->protocol_date))
				$protocol->protocol_date = $this->modify($protocol->protocol_date);

			if ($this->isCorrect($protocol->order_date))
				$protocol->order_date = $this->modify($protocol->order_date);

			if ($this->isCorrect($protocol->enroll_date))
				$protocol->enroll_date = $this->modify($protocol->enroll_date);

			if ($this->isSave)
				$protocol->save();

			$this->isSave = false;
		}
    }

    private function isCorrect($str_date)
	{
		$this->isSave = true;

		if (strpos($str_date, '.') === false )
			return false;

		return true;
	}

	private function modify($str_date)
	{
		return datetime('Y-m-d', $str_date);
	}


}
