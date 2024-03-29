<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|min:3',
        ];
    }

    public function prepare(array $input)
    {
        if (strpos(\Route::getCurrentRoute()->getActionName(), '@store')) {
            if (!empty($this->get('slug'))) {
                $slug =  $this->get('slug');
            } else {
                $slug = str_slug($this->get('name'));
            }
            $input['slug'] =  $slug;
            if (empty($this->get('title'))) {
                $input['title'] =  $this->get('name');
            }
        }
        return $input;
    }
}
