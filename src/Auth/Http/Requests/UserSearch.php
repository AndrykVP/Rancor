<?php

namespace AndrykVP\Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSearch extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attribute' => 'required|in:id,first_name,last_name,email',
            'value' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'attribute.in' => 'The selected :attribute is invalid. Acceptable options are: "id", "first_name", "last_name" and "email"'
        ];
    }
}
