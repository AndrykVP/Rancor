<?php

namespace AndrykVP\Rancor\Structure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentForm extends FormRequest
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
            'name' => ['required', 'string', Rule::unique('structure_departments')->ignore($this->id)],
            'color' => 'nullable|string|max:7|starts_with:#',
            'faction_id' => 'required|integer|exists:structure_factions,id',
            'description' => 'nullable|string',
        ];
    }
}
