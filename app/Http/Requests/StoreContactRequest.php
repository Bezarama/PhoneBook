<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:255'],
            'middle_name' => ['nullable', 'max:255'],
            'last_name' => ['nullable', 'max:255'],
            'phone' => ['required', 'max:255'],
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
     * Подготовить телефон, отметку об избранном
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
