<?php

namespace AndrykVP\Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PermissionForm extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => Str::slug($this->name),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('rancor_permissions')->ignore($this->id)],
            'description' => 'required|min:3|max:3000',
        ];
    }
}
