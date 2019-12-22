<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DictionaryType extends Model
{
    protected $fillable = ['title', 'slug'];

    static public function getMenuDictionaries()
	{
		$result = [];

		$list = DictionaryType::get();

		foreach ($list as $type)
		{
			$result[] = ['title' => $type->title,  'icon' => '', 'uri' => 'dic-type/edit/'.$type->slug];
		}


		return $result;
	}
}
