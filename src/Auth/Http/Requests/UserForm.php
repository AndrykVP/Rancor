<?php

namespace AndrykVP\Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserForm extends FormRequest
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
            'name' => ['required', 'string', Rule::unique('users')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'rank_id' => 'nullable|integer|exists:ranks,id',
            'permissions' => 'nullable|array',
            'roles' => 'nullable|array'
        ];
    }
}
