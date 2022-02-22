<?php

namespace Rancor\Structure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AwardForm extends FormRequest
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
			'name' => ['required', 'string', Rule::unique('structure_awards')->ignore($this->id)],
			'description' => 'required|string',
			'code' => ['required', 'string', Rule::unique('structure_awards')->ignore($this->id)],
			'levels' => 'nullable|integer|min:1|max:255',
			'priority' => 'nullable|integer|min:1|max:255',
			'type_id' => 'required|integer|exists:structure_award_types,id'
		];
	}
}
