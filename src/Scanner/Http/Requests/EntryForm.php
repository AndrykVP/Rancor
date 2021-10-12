<?php

namespace AndrykVP\Rancor\Scanner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntryForm extends FormRequest
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
            'updated_by' => $this->user()->id,
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
            'entity_id' => 'required|integer',
            'type' => 'required|string',
            'name' => 'required|string',
            'owner' => 'required|string',
            'alliance' => 'required|integer|min:-1|max:1',
            'updated_by' => 'required|exists:users,id',
        ];
    }
}
