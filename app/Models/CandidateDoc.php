<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateDoc extends Model
{
    protected $table = 'candidates_docs';

    protected $fillable = ['candidate_id', 'college_id', 'filename', 'fcomment', 'type', 'filesize', 'doc_type_id', 'original_name'];

    public function docType()
    {
        return $this->belongsTo('App\Models\DocType', 'doc_type_id');
    }
}
