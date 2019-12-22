<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DictionaryType;
use App\Models\Dictionary;

class DictionaryController extends Controller
{
    public function dictionaryType()
	{
		$listType = DictionaryType::orderBy('title')->where('system_id', $this->educationSystemId)->get();
		return view('dictionaries.type')->with('listType', $listType);
	}

	public function dictionaryTypeCreate()
	{
		return view('dictionaries.type-create');
	}

	public function dictionaryTypeStore(Request $request)
	{
        $data = $request->all();
		DictionaryType::create($data);
        return redirect('dic-type');
	}

	public function dictionaryTypeEdit($slug)
	{
		$item = DictionaryType::where('slug', $slug)->first();

		$college_id = \Auth::user()->hasRole('admin') ? 0 : \Auth::user()->college_id;

		if (\Auth::user()->hasRole('admin'))
			$listDirectories = Dictionary::where('type_id', $item->id)->where('system_id', $this->educationSystemId)->whereIn('college_id' , [0])->get();
		else
			$listDirectories = Dictionary::where('type_id', $item->id)->where('system_id', $this->educationSystemId)->whereIn('college_id' , [$college_id, 0])->get();

		return view('dictionaries.type-edit')->with(['item' => $item, 'listDirectories' => $listDirectories]);
	}

	public function dictionaryTypeUpdate(Request $request, $id)
	{
		$item = DictionaryType::find($id);
        $item->update($request->all());

		return redirect('dic-type');
	}

	public function dictionaryTypeDestroy($id)
	{
		DictionaryType::destroy($id);
        return redirect('dic-type');
	}


	public function dictionaryStore(Request $request)
	{
		$college_id = \Auth::user()->hasRole('admin') ? 0 : \Auth::user()->college_id;


		$directory = new Dictionary;
		$directory->title = $request->input('dictionary_title');
		$directory->value = $request->has('dictionary_value') ? $request->input('dictionary_value') : null;
		$directory->slug = $request->has('dictionary_slug') ? $request->input('dictionary_slug') : null;
		$directory->type_id = $request->input('type_id');
		$directory->college_id = $college_id;
        $directory->system_id = $this->educationSystemId;
		$directory->save();

        return redirect('dic-type/edit/'.$request->input('slug_type'));
	}

	public function dictionaryUpdate(Request $request, $id)
	{
		$directory = Dictionary::find($id);
        $directory->title = $request->input('dictionary_title');
        $directory->value = $request->has('dictionary_value') ? $request->input('dictionary_value') : null;
        $directory->slug = $request->has('dictionary_slug') ? $request->input('dictionary_slug') : null;
        $directory->save();

		return redirect('dic-type/edit/'.$request->input('slug_type'));
	}

	public function dictionaryDestroy(Request $request, $id)
	{
		Dictionary::destroy($id);
        return redirect('dic-type/edit/'.$request->input('slug_type'));
	}


}
