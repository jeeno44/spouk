<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormTraining extends Model
{
    public $table = 'form_training';  
    
    protected $fillable = ['title'];
}