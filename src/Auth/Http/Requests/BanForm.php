<?php

namespace Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BanForm extends FormRequest
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
			'updated_by' => $this->user()->id,
			'status' => $this->status ? true : false,
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
			'updated_by' => 'required|integer|exists:users,id',
			'status' => 'required|boolean',
			'reason' => 'required|string|max:255'
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
            'updated_by' => $this->user()->id,
            'status' => $this->status ? true : false,
        ]);
    }

    public function rules(): array
    {
        return [
            'updated_by' => 'required|integer|exists:users,id',
            'status' => 'required|boolean',
            'reason' => 'required|string|max:255'
        ];
    }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
