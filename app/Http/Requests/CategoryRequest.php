<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
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
            'name.required' => 'Необходимо заполнить наименование категории',
            'name.min' => 'Наименование категории должно быть не менее 2 символов',
            'name.max' => 'Наименование категории должно быть не более 128 символов'
        ];
    }
}
