<?php

namespace AndrykVP\Rancor\Forums\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReplyForm extends FormRequest
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
            'user_id' => $this->user()->id,
        ]);
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
            'body' => 'required|string|min:6',
            'discussion_id' => 'required|integer|exists:forum_discussions,id',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
