<?php

namespace AndrykVP\Rancor\Forums\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoardForm extends FormRequest
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
        $id = last($this->segments());

        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'slug' => ['required', 'string', Rule::unique('forum_boards')->ignore($id)],
            'category_id' => 'required|integer|exists:forum_categories,id',
            'parent_id' => 'nullable|integer|exists:forum_boards,id',
            'order' => 'required|integer',
        ];
    }
}
