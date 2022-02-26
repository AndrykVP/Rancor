<?php

namespace Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PermissionForm extends FormRequest
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
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->merge([
			'name' => Str::slug($this->name),
		]);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => ['required', 'string', Rule::unique('rancor_permissions')->ignore($this->id)],
			'description' => 'required|min:3|max:3000',
		];
	}
=======
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => Str::slug($this->name),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('rancor_permissions')->ignore($this->id)],
            'description' => 'required|min:3|max:3000',
        ];
    }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
