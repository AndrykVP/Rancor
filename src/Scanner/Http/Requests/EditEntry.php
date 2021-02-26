<?php

namespace AndrykVP\Rancor\Scanner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditEntry extends FormRequest
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
            'type' => 'requred|string',
            'name' => 'requred|string',
            'owner' => 'requred|string',
            'position' => 'requred|array',
            'updated_by' => 'required|exists:users,id',
            'last_seen' => 'required|date'
        ];
    }
}
