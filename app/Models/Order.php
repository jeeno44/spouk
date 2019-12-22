<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['college_id', 'system_id', 'title', 'date', 'number', 'file'];

    public function candidates() {
        return $this->belongsToMany(Candidate::class, 'candidate_order');
    }
}
