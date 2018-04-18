<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class SignalsRequest extends FormRequest {

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

        return [
            'type' => 'required|numeric',
            'comment_id' => 'required|numeric|exists:comments,id',
            'guilt_id' => 'required|numeric|exists:users,id',
            'content' => 'min:3'
        ];
    }

    public function messages()
    {
        return [
          'guilt_id.required' => 'Il y a eu un problème lors du renseignement du messager fautif.'
        ];
    }
}
