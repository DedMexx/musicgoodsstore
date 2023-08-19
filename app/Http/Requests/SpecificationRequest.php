<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:128',
            'description' => 'nullable'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Необходимо заполнить наименование характеристики',
            'name.min' => 'Наименование характеристики должно быть не менее 2 символов',
            'name.max' => 'Наименование характеристики должно быть не более 128 символов'
        ];
    }
}
