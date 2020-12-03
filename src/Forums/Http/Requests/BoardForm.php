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
        return [
            'title' => 'required|string',
            'slug' => ['required', 'string', Rule::unique('forum_boards')->ignore($this->id)],
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:forum_categories,id',
            'parent_id' => 'nullable|integer|exists:forum_boards,id',
            'groups' => 'required|array',
            'order' => ['required','integer', Rule::unique('forum_boards')->where(function ($query) {
                return $query->where('category_id', $this->category);
            })->ignore($this->id)],
        ];
    }
}
