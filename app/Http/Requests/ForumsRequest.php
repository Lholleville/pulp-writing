<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumsRequest extends FormRequest
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
    //dd($this->request->all());
        $rules = [
            'name' => 'required|min:3',
            'description' => 'string|min:3|nullable',
            'collec_id' => 'integer|',
        ];
        if($this->request->get('collec_id') != '0'){
            $rules['collec_id'] .= '|exists:collecs,id';
        }
        if($this->method() == "POST"){
            $rules['collec_id'] .= '|unique:forums,collec_id';
        }


        return $rules;
    }
}
