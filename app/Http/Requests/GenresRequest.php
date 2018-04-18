<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenresRequest extends FormRequest
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
            'name' => "required|min:2",
            'color' => "string|size:6"
        ];

        if($this->method() == "POST"){
            $rules['name'] .= "|unique:genres";
        }

        return $rules;
    }
}
