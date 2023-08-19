<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
    public function rules()
    {
        return [
            'number' => 'required|max:128',
            'date' => 'required|date',
            'supplier' => 'required|max:64|exists:suppliers,name'
        ];
    }

    public function messages()
    {
        return [
            'number.required' => 'Необходимо заполнить номер накладной',
            'number.max' => 'Номер накладной должно быть не более 128 символов',
            'date.required' => 'Необходимо заполнить дату накладной',
            'date.date' => 'Необходимо ввести валидную дату',
            'supplier.required' => 'Необходимо написать название поставщика',
            'supplier.max' => 'Название поставщика должно быть не более 64 символов',
            'supplier.exists' => 'Поставщик с указанным названием не существует'
        ];
    }
}
