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
            'role_id' => 'required|exists:users,id',
            'primary' => '',
        ];

        if($this->method() == "POST"){
            $rules['name'] .= "|unique:collecs";
            $rules['primary'] .= "primaryCREATE";
        }else{
            $rules['primary'] .= "primaryUPDATE";
        }
        return $rules;
    }

    public function messages(){
        return [
            'role_id' => 'L\'utilisateur n\'existe pas.',
            'primary' => 'Il ne peut y avoir qu\'une seule collection - 0 ; Pour y remédier, enlevez l\'attribut "collection 0" à la collection 0 actuelle.',
        ];
    }
}
