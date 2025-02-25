<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255|unique:users',
            'phone_number' => 'required|string|unique:users|phone:AUTO,UA'
        ];
    }

    /**
     * Сообщения об ошибках валидации.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Имя пользователя обязательно для заполнения.',
            'username.unique' => 'Это имя пользователя уже занято.',
            'phone_number.required' => 'Номер телефона обязателен для заполнения.',
            'phone_number.unique' => 'Этот номер телефона уже зарегистрирован.',
            'phone_number.phone' => 'Используйте формат +380XXXXXXXXX',
        ];
    }
}
