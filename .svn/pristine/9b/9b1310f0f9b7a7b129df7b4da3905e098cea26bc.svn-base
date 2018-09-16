<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;


class CreateRecipeRequest extends FormRequest
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
        $rules = [
            'name' => 'required|min:3|unique:recipes,name,null,id,user_id,{Auth::user()->id}',
            'categories' => 'required',
            'persons' => 'required|numeric|min:1',
        ];

        
        /*$photos = count($this->input('photos'));

        foreach(range(0, $photos) as $index) {
            $rules['photos_' . $index] = 'image|mimes:jpeg,gif,png|max:4000';
        }*/
 
        return $rules;
    }
}
