<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'phone', 'first_name', 'last_name', 'middle_name', 'college_id', 'subdivision_id', 'specialization_id', 'activation_code', 'activated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function college()
    {
        return $this->belongsTo('App\Models\College', 'college_id');
    }
    
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_user');
    }

    public function hasRole($check)
    {
        return in_array($check, array_pluck($this->roles->toArray(), 'title'));
    }

    public function access()
    {
        return $this->belongsToMany('App\Models\AccessLevel', 'access_level_user', 'user_id', 'access_level_id');
    }

    public function hasAccess($check)
    {
        return in_array($check, array_pluck($this->access->toArray(), 'title'));
    }

    public function subdivision()
    {
        return $this->belongsTo('App\Models\Subdivision');
    }

    static public function getTeachers()
	{
		return Role::find(4)->users()->where('college_id', \Auth::user()->college_id)->get();
	}

    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class,'discipline_user');
    }
}
