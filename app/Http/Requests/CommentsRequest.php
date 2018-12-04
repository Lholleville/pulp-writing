<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentsRequest extends FormRequest
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
        return [
            'content' => 'required|min:3',
            'user_id' => 'exists:users,id',
            'chapter_id' => 'exists:chapters,id',
            'article_id' => 'exists:articles,id',
            'journal_id' => 'exists:journals,id',
        ];
    }
}
