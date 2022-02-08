<?php

namespace AndrykVP\Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormSelf extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->id)],
            'nickname' => 'nullable|string|max:255',
            'quote' => 'nullable|string|max:500',
            'homeplanet_id' => 'nullable|integer|exists:swc_planets,id',
        ];
    }
}
