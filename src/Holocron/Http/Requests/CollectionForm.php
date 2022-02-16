<?php

namespace Rancor\Holocron\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CollectionForm extends FormRequest
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
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->merge([
			'slug' => Str::slug($this->slug),
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
			'name' => ['required', 'string', Rule::unique('holocron_collections')->ignore($this->id)],
			'slug' => ['required', 'string', Rule::unique('holocron_collections')->ignore($this->id)],
			'description' => 'required|string',
		];
	}
}
