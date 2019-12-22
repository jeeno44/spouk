<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonetaryBasis extends Model
{
    public $table = 'monetary_basis';  
    
    protected $fillable = ['title'];
}