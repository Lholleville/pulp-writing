<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollecsRequest extends FormRequest
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
            'name' => 'required|min:2',
            'description' => 'min:2',
            'avatar' => 'image',
            'online' => 'boolean',
            'role_id' => 'required|exists:users,id'
        ];
        if($this->method() == "POST"){
            $rules['name'] .= "|unique:collecs";
        }
        return $rules;
    }

    public function messages(){
        return [
            'role_id' => 'L\'utilisateur n\'existe pas.',
        ];
    }
}
