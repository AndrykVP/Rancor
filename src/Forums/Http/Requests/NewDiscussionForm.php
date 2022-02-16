<?php

namespace Rancor\Forums\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewDiscussionForm extends FormRequest
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
			'author_id' => $this->user()->id,
			'is_sticky' => $this->is_sticky ? true : false,
			'is_locked' => $this->is_locked ? true : false,
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
			'name' => 'required|string',
			'body' => 'required|string',
			'is_sticky' => 'required|boolean',
			'is_locked' => 'required|boolean',
			'board_id' => 'required|integer|exists:forum_boards,id',
			'author_id' => 'required|integer|exists:users,id',
		];
	}
}
