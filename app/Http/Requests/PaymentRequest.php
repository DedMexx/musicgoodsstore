<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'date' => 'required|date',
            'amount' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Необходимо заполнить дату накладной',
            'date.date' => 'Необходимо ввести валидную дату',
            'selling_price.required' => 'Поле Сумма платежа является обязательным.',
            'selling_price.numeric' => 'Поле Сумма платежа должно быть числовым значением.',
        ];
    }
}
