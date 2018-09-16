<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UploadRecipesPhotosRequest extends FormRequest
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
        
        /*$photos = count($this->input('photos'));

        foreach(range(0, $photos) as $index) {
            $rules['photos_' . $index] = 'image|mimes:jpeg,jpg,gif,png|max:4000';
        }*/

        $rules['photos.*'] = 'image|mimes:jpeg,jpg,gif,png|max:4000';
 
        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        $messages['photos.*.mimes'] = 'Only jpeg, jpg, png and gif images are allowed';
        $messages['photos.*.max']  = 'Maximum allowed size for an image is 2MB';

        return $messages;
    }
}
