<?php

namespace AndrykVP\Rancor\Structure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RankForm extends FormRequest
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
            'name' => 'required|string',
            'department_id' => 'required|integer|exists:structure_departments,id',
            'level' => 'required|integer|min:0|max:255',
            'description' => 'nullable|string',
        ];
    }
}
