<?php

namespace Rancor\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleForm extends FormRequest
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
			'is_published' => $this->is_published ? true : false,
			'published_at' => $this->is_published ? ($this->published_at ?? now()) : null
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
			'body' => 'required|min:3',
			'description' => 'required|string',
			'is_published' => 'required|boolean',
			'tags' => 'nullable|array',
			'published_at' => 'nullable|date'
		];
	}
}
