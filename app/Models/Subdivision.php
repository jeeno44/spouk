<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subdivision extends Model
{
    protected $fillable = ['title', 'code', 'college_id', 'system_id', 'full_title', 'inn', 'ogrn', 'type',
        'form', 'parent_inn', 'views', 'okopf', 'okfs', 'okved', 'strukture', 'make_date', 'uchred',
        'law_address', 'post_address', 'city', 'okpo', 'oktmo', 'okato', 'actual_date', 'status', 'phone',
        'fax', 'email', 'site', 'licence_number', 'licence_date', 'licence_serie', 'licence_date_finish',
        'reg_number', 'blank_number', 'blank_date', 'blank_finish'
    ];
}
