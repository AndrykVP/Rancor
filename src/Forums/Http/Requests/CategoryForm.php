<?php

namespace AndrykVP\Rancor\Forums\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryForm extends FormRequest
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
            'color' => 'nullable|integer|size:6',
            'slug' => ['required', 'string', Rule::unique('forum_categories')->ignore($id)],
            'order' => ['required', 'integer', Rule::unique('forum_categories')->ignore($id)],
            'groups' => 'nullable|array',
            'boards' => 'nullable|array',
        ];
    }
}
