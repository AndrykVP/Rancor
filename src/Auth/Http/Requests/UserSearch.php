<?php

namespace Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSearch extends FormRequest
{
<<<<<<< HEAD
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
			'attribute' => 'required|in:id,first_name,lat_name,email',
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
			'attribute.in' => 'The selected :attribute is invalid. Acceptable options are: "id", "first_name", "last_name" and "email"'
		];
	}
=======
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
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
