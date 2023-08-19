<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManufacturerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:64',
            'description' => 'nullable',
            'country' => 'nullable|min:2|max:128|regex:/^[\p{L}\s]+$/u',
            'region' => 'nullable|min:2|max:128|regex:/^[\p{L}\s]+$/u',
            'city' => 'nullable|min:2|max:128',
            'street' => 'nullable|min:2|max:128',
            'house' => 'nullable|max:15', //regex:/^(?=.*[0-9])[a-zA-Z0-9-.]+$/
            'post_index' => 'nullable|min:2|max:20',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Необходимо заполнить наименование производителя',
            'name.min' => 'Наименование производителя должно быть не менее 2 символов',
            'name.max' => 'Наименование производителя должно быть не более 64 символов',
            'country.required' => 'Необходимо заполнить страну',
            'country.min' => 'Название страны должно быть не менее 2 символов',
            'country.max' => 'Название страны должно быть не более 128 символов',
            'country.regex' => 'Страна должна содержать только буквы',
            'region.required' => 'Необходимо заполнить регион',
            'region.min' => 'Название региона должно быть не менее 2 символов',
            'region.max' => 'Название региона должно быть не более 128 символов',
            'region.regex' => 'Регион должен содержать только буквы',
            'city.required' => 'Необходимо заполнить город',
            'city.min' => 'Название города должно быть не менее 2 символов',
            'city.max' => 'Название города должно быть не более 128 символов',
            'street.required' => 'Необходимо заполнить улицу',
            'street.min' => 'Название улицы должно быть не менее 1 символа',
            'street.max' => 'Название улицы должно быть не более 128 символов',
            'house.required' => 'Необходимо заполнить дом',
            'house.min' => 'Дом должен быть не менее 1 символа',
            'house.max' => 'Дом должен быть не более 15 символов',
//            'house.regex' => 'Дом должен иметь хотя бы одну цифру и может влючать буквы, тире, точки',
            'post_index.required' => 'Необходимо заполнить почтовый индекс',
            'post_index.min' => 'Почтовый индекс должен быть не менее 5 символов',
            'post_index.max' => 'Почтовый индекс должен быть не более 20 символов'
        ];
    }
}
