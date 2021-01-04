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
            'name' => 'required|string',
            'slug' => ['required', 'string', Rule::unique('forum_boards')->ignore($this->id)],
            'description' => 'nullable|string',
            'category_id' => 'nullable|required_without:parent_id|integer|exists:forum_categories,id',
            'parent_id' => 'nullable|required_without:category_id|integer|exists:forum_boards,id',
            'groups' => 'required|array',
            'order' => ['required','integer', Rule::unique('forum_boards')->where(function ($query) {
                return $query->where('category_id', $this->category_id);
            })->ignore($this->id)],
        ];
    }
}
