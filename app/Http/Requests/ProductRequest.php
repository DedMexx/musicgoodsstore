<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
//    public function authorize(): bool
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'warranty' => 'nullable|string|max:255',
            'manufacturer' => 'required|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Поле Наименование является обязательным.',
            'name.string' => 'Поле Наименование должно быть строкой.',
            'name.max' => 'Поле Наименование должно содержать не более :max символов.',
            'description.string' => 'Поле Описание должно быть строкой.',
            'image.image' => 'Поле Изображение должно быть изображением.',
            'image.mimes' => 'Поле Изображение должно иметь формат JPEG, JPG, PNG, GIF или SVG.',
            'image.max' => 'Поле Изображение должно быть не более :max Кб.',
            'purchase_price.required' => 'Поле Цена покупки является обязательным.',
            'purchase_price.numeric' => 'Поле Цена покупки должно быть числовым значением.',
            'selling_price.required' => 'Поле Цена продажи является обязательным.',
            'selling_price.numeric' => 'Поле Цена продажи должно быть числовым значением.',
            'warranty.string' => 'Поле Гарантия должно быть строкой.',
            'warranty.max' => 'Поле Гарантия должно содержать не более :max символов.',
            'manufacturer.required' => 'Поле Производитель является обязательным.',
            'manufacturer.string' => 'Поле Производитель должно быть строкой.',
            'manufacturer.max' => 'Поле Производитель должно содержать не более :max символов.',
        ];
    }

}
