<?php

namespace Rancor\Holocron\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditNodeForm extends FormRequest
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
            'editor_id' => $this->user()->id,
            'is_public' => $this->is_public ? true : false,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(3);

        return [
            'name' => 'required|string',
            'body' => 'required|min:3',
            'is_public' => 'required|boolean',
            'collections' => 'nullable|array',
            'editor_id' => 'required|integer|exists:users,id',
        ];
    }
}
