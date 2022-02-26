<?php

namespace Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormSelf extends FormRequest
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
			'first_name' => 'required|string|max:255',
			'last_name' => 'required|string|max:255',
			'email' => ['required', 'email', Rule::unique('users')->ignore($this->id)],
			'nickname' => 'nullable|string|max:255',
			'quote' => 'nullable|string|max:500',
			'homeplanet_id' => 'nullable|integer|exists:swc_planets,id',
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->id)],
            'nickname' => 'nullable|string|max:255',
            'quote' => 'nullable|string|max:500',
            'homeplanet_id' => 'nullable|integer|exists:swc_planets,id',
        ];
    }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
