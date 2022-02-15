<?php

namespace Rancor\Scanner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerritoryFilter extends FormRequest
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
        $filter = [];
        if($this->has('neutral')) $filter[] = 0;
        if($this->has('friend')) $filter[] = 1;
        if($this->has('enemy')) $filter[] = -1;

        $this->merge([
            'filter' => empty($filter) ? [-1, 0, 1] : $filter,
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
            'filter' => 'required|array',
            'filter.*' => 'integer|min:-1|max:1',
        ];
    }
}
