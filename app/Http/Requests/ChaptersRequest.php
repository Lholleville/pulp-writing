<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChaptersRequest extends FormRequest
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
            'content' => 'required|min:2',
            'POV' => 'string',
            'order' => 'integer',
            'words' => 'integer',
            'views' => 'integer',
            'online' => 'boolean',
            'book_id' => 'integer',
            'user_id' => 'integer',
        ];

        if($this->method() == 'POST'){
            $rules['name'] .= '|namechapter';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'namechapter' => 'Un chapitre porte déjà ce nom dans votre histoire',
        ];
    }
}
