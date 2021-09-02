<?php

namespace AndrykVP\Rancor\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewArticleForm extends FormRequest
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
     * Prepare the data for validation
     *
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
            'author_id' => $this->user()->id,
            'is_published' => $this->is_published ? true : false,
            'published_at' => $this->is_published ? now() : null
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'body' => 'required|min:3',
            'description' => 'required|string',
            'is_published' => 'required|boolean',
            'tags' => 'nullable|array',
            'author_id' => 'required|integer|exists:users,id',
            'published_at' => 'nullable|date'
        ];
    }
}
