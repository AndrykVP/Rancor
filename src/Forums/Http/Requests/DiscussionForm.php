<?php

namespace AndrykVP\Rancor\Forums\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscussionForm extends FormRequest
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
            'is_sticky' => 'required|boolean',
            'board_id' => 'required|integer|exists:forum_boards,id',
            'author_id' => 'required|integer|exists:users,id',
        ];
    }
}
