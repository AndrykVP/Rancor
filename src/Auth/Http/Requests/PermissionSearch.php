<?php

namespace AndrykVP\Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionSearch extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attribute' => 'required|in:id,name',
            'value' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'attribute.in' => 'The selected :attribute is invalid. Acceptable options are: "id" and "name"'
        ];
    }
}
