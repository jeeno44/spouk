<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $fillable = ['type', 'protocol_date', 'protocol_number', 'order_date', 'order_number', 'enroll_date',
        'file', 'approved', 'candidates', 'college_id', 'system_id'];

	public function attachCandidate($candidateIds)
	{
        \DB::table('protocol_candidate')->where('protocol_id', $this->id)->delete();
		foreach ($candidateIds as $candidateId)
		{
			\DB::table('protocol_candidate')->insert(['protocol_id' => $this->id, 'candidate_id' => $candidateId ]);
		}
	}

	public function dicType()
	{
		return $this->belongsTo(\App\Models\Dictionary::class, 'type', 'slug');
	}

	public function candidates()
    {
        return \DB::table('protocol_candidate')->where('protocol_id', $this->id)->pluck('candidate_id');
    }

}
