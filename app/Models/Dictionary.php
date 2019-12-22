<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
	static public function getBySlug($slug)
	{
		$type = DictionaryType::where('slug', $slug)->first();

		return static::orderBy('title')->where('type_id', $type->id)->get();
	}

	static public function type()
	{
		return DictionaryType::belongsTo('App\Models\DictionaryType');
	}

}
