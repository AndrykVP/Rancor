<?php

namespace AndrykVP\Rancor\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleForm extends FormRequest
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
        $id = $this->segment(3);

        return [
            'title' => ['required', 'string', Rule::unique('articles')->ignore($id)],
            'content' => 'required|string',
            'is_published' => 'required|boolean',
            'author_id' => 'sometimes|required|integer|exists:users,id',
            'editor_id' => 'sometimes|required|integer|exists:users,id',
        ];
    }
}
