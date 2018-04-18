<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BooksRequest extends FormRequest
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
            'name'   =>  "required|min:2",
            'avatar' =>  "image|max:2048",
            'summary' => "string|min:10",
            'genre_id' => "integer|exists:genres,id",
            'user_id' => "integer|exists:users,id",
            'statut_id' => "required|integer|exists:statuts,id",
            'parent_id' => "integer",
            'online' => "boolean"
        ];

        if($this->method() == "POST"){
            $rules['name'] .= "|unique:books";
        }

        return $rules;
    }
}
