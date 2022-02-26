<?php

namespace Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserForm extends FormRequest
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
			'rank_id' => $this->rank_id ?: null,
		]);
=======
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'rank_id' => $this->rank_id ?: null,
        ]);
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		if($this->awards != null)
		{
			$awards = [];
			foreach($this->awards as $award => $level)
			{
				if($level > 0)
				{
					$awards[$award] = ['level' => $level];
				}
			}
			$this->merge([
				'awards' => $awards,
			]);
		}
	}

<<<<<<< HEAD
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
			'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->id)],
			'nickname' => 'nullable|string|max:255',
			'quote' => 'nullable|string|max:500',
			'rank_id' => 'nullable|integer|exists:structure_ranks,id',
			'avatar' => 'nullable|url',
			'signature' => 'nullable|string',
			'avatarFile' => 'nullable|file|max:1000|mimetypes:image/png',
			'signatureFile' => 'nullable|file|max:1000|mimetypes:image/png',
			'awards' => 'nullable|array',
			'roles' => 'nullable|array',
			'groups' => 'nullable|array',
		];
	}
=======
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->id)],
            'nickname' => 'nullable|string|max:255',
            'quote' => 'nullable|string|max:500',
            'duty' => 'nullable|string|max:40',
            'rank_id' => 'nullable|integer|exists:structure_ranks,id',
            'avatar' => 'nullable|url',
            'signature' => 'nullable|string',
            'avatarFile' => 'nullable|file|max:1000|mimetypes:image/png',
            'signatureFile' => 'nullable|file|max:1000|mimetypes:image/png',
            'awards' => 'nullable|array',
            'roles' => 'nullable|array',
            'groups' => 'nullable|array',
        ];
    }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
