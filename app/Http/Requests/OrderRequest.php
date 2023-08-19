<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'date' => 'required|date',
            'email' => 'required|max:191|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/|exists:clients,email',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Необходимо заполнить дату накладной',
            'date.date' => 'Необходимо ввести валидную дату',
            'email.required' => 'Необходимо заполнить email',
            'email.regex' => 'E-mail должен быть валидным',
            'email.max' => 'Email должен быть не более 191 символов',
            'email.exists' => 'Клиент с указанным E-mail не существует'
        ];
    }
}
