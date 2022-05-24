<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequestBase extends FormRequest
{

    /**
     * Общие правила валидации
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'is_favourite' => ['boolean'],
        ];
    }

    /**
     * Названия аттрибутов для валидации
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'Имя',
            'middle_name' => 'Отчество',
            'last_name' => 'Фамилия',
            'phone' => 'Телефон',
            'is_favourite' => 'Избранное',
        ];
    }

    /**
     * Подготовить перед записью некоторые поля
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => preg_replace('/\D/', '', $this->phone),
            'is_favourite' => isset($this->is_favourite) ? 1 : 0,
        ]);
    }

}
