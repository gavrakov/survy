<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class AddGroceryToTheRecipeRequest extends FormRequest
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
            'f_grocery' => 'required|numeric',
            'f_quantity' => 'required|numeric|min:0.01',
        ];
 
        return $rules;
    }


    
}
