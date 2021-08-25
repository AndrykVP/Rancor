<?php

namespace AndrykVP\Rancor\Scanner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewTerritoryType extends FormRequest
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
            'name' => 'required|string|unique:scanner_territory_types,name',
            'image' => 'required|url',
        ];
    }
}
