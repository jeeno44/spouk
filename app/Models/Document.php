<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['document_type_id', 'title', 'docx_link', 'pdf_link', 'out_id', 'candidate_id'];

    public function type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }
}
