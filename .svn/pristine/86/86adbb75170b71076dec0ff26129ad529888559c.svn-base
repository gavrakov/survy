<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Rules\ValidatePlanDateExists;


class CreatePlanRequest extends FormRequest
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
            'name' => 'required|min:3|max:255', 
            'persons' => 'required|numeric|min:1',
            'date_from' => ['required','date','date_format:"m/d/Y"','after_or_equal:'. date('m/d/Y') , new ValidatePlanDateExists($this->input('date_to'))],
            'date_to' => 'required|date|date_format:"m/d/Y"|after_or_equal:date_from',
            'description' => 'required'
       
        ];

        return $rules;
    }
}
