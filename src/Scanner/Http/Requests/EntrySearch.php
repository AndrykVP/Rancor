<?php

namespace Rancor\Scanner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntrySearch extends FormRequest
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
            'attribute' => [
                'required',
                Rule::in(['entity_id','type','owner','name']),
            ],
            'value' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'attribute.in' => 'The selected :attribute is invalid. Acceptable options are: "entity id", "type", "owner" and "name"'
        ];
    }
}
