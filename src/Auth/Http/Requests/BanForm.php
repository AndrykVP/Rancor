<?php

namespace AndrykVP\Rancor\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BanForm extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'updated_by' => $this->user()->id,
            'status' => $this->status ? true : false,
        ]);
    }

    public function rules(): array
    {
        return [
            'updated_by' => 'required|integer|exists:users,id',
            'status' => 'required|boolean',
            'reason' => 'required|string|max:255'
        ];
    }
}
