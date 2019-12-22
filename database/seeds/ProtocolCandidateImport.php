<?php

use Illuminate\Database\Seeder;

class ProtocolCandidateImport extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $listProtocol = \App\Models\Protocol::orderBy('id')->get();

		foreach ($listProtocol as $protocol)
		{
			$candidates = json_decode($protocol->candidates, true);

			foreach ($candidates as $candidate)
			{
				$item = DB::table('protocol_candidate')->where([
    						['protocol_id', '=',  $protocol->id],
    						['candidate_id', '=', $candidate]])->first();

				if (empty($item))
					DB::table('protocol_candidate')->insert(['protocol_id' => $protocol->id, 'candidate_id' => $candidate ]);
			}

		}
    }
}
