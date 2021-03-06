<?php

namespace AndrykVP\Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserForm extends FormRequest
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
            'rank_id' => $this->rank_id ?: null,
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
            'name' => ['required', 'string', Rule::unique('users')->ignore($this->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->id)],
            'nickname' => 'nullable|string',
            'quote' => 'nullable|string',
            'rank_id' => 'nullable|integer|exists:structure_ranks,id',
            'avatar' => 'nullable|file|max:1000|mimetypes:image/png',
            'signature' => 'nullable|file|max:1000|mimetypes:image/png',
            'roles' => 'required|array',
            'groups' => 'required|array',
        ];
    }
}
