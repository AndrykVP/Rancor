<?php

namespace AndrykVP\Rancor\Structure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentSearch extends FormRequest
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
            'attribute' => [
                'required',
                Rule::in(['id', 'name', 'description']),
            ],
            'value' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'attribute.in' => 'The selected :attribute is invalid. Acceptable options are: "id", "name" and "description"'
        ];
    }
}
