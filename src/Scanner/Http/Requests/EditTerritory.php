<?php

namespace AndrykVP\Rancor\Scanner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTerritory extends FormRequest
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
            'patrolled_by' => $this->user()->id,
            'last_patrol' => now(),
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
            'name' => 'nullable|string',
            'type_id' => 'nullable|integer|exists:scanner_territory_types,id',
            'patrolled_by' => 'nullable|integer|exists:users,id',
            'last_patrol' => 'required|date',
        ];
    }
}
