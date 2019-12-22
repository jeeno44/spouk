<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['name', 'slug', 'content', 'enabled', 'title', 'keywords', 'description', 'image', 'date', 'desc'];
}
