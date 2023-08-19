<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:128',
            'email' => 'required|max:160|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/',
            'phone' => 'required|min:6|max:32|regex:/^[+\-()0-9]+$/',
            'country' => 'required|min:2|max:128|regex:/^[\p{L}\s.\-]+$/u',
            'region' => 'required|min:2|max:128|regex:/^[\p{L}\s.\-]+$/u',
            'city' => 'required|min:2|max:128',
            'street' => 'required|min:2|max:128',
            'house' => 'required|max:15', //|regex:/^(?=.*[0-9])[a-zA-Z0-9-.]+$/
            'post_index' => 'required|min:2|max:32',
            'first_name' => 'required|max:255',//alpha
            'last_name' => 'required|max:255',//alpha
            'third_name' => 'nullable|max:255'//alpha
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Необходимо заполнить наименование поставщика',
            'name.min' => 'Наименование поставщика должно быть не менее 2 символов',
            'name.max' => 'Наименование поставщика должно быть не более 128 символов',
            'email.required' => 'Необходимо заполнить email',
            'email.regex' => 'E-mail должен быть валидным',
            'email.max' => 'Email должен быть не более 160 символов',
            'phone.required' => 'Необходимо заполнить номер телефона',
            'phone.max' => 'Номер телефона должен содержать не более 32 цифр',
            'phone.min' => 'Номер телефона должен содержать не менее 6 цифр',
            'phone.regex' => 'Номер телефона может содержать только цифры, +, -, ) и (',
            'country.required' => 'Необходимо заполнить страну',
            'country.min' => 'Название страны должно быть не менее 2 символов',
            'country.max' => 'Название страны должно быть не более 128 символов',
            'country.regex' => 'Страна должна содержать только буквы, точку и дефис',
            'region.required' => 'Необходимо заполнить регион',
            'region.min' => 'Название региона должно быть не менее 2 символов',
            'region.max' => 'Название региона должно быть не более 128 символов',
            'region.regex' => 'Регион должен содержать только буквы, точку и дефис',
            'city.required' => 'Необходимо заполнить город',
            'city.min' => 'Название города должно быть не менее 2 символов',
            'city.max' => 'Название города должно быть не более 128 символов',
            'street.required' => 'Необходимо заполнить улицу',
            'street.min' => 'Название улицы должно быть не менее 2 символа',
            'street.max' => 'Название улицы должно быть не более 128 символов',
            'house.required' => 'Необходимо заполнить дом',
            'house.max' => 'Дом должен быть не более 15 символов',
//            'house.regex' => 'Дом должен иметь хотя бы одну цифру и может включать буквы, тире, точки',
            'post_index.required' => 'Необходимо заполнить почтовый индекс',
            'post_index.min' => 'Почтовый индекс должен быть не менее 2 символов',
            'post_index.max' => 'Почтовый индекс должен быть не более 32 символов',
            'first_name.required' => 'Необходимо заполнить имя',
//            'first_name.alpha' => 'Имя должно содержать только буквы',
            'first_name.max' => 'Имя должно быть не более 255 символов',
            'last_name.required' => 'Необходимо заполнить фамилию',
//            'last_name.alpha' => 'Фамилия должна содержать только буквы',
            'last_name.max' => 'Фамилия должна быть не более 255 символов',
//            'third_name.alpha' => 'Отчество должно содержать только буквы',
            'third_name.max' => 'Отчество не может превышать 255 символов'
        ];
    }

}
