<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|min:2',
            'email' => 'required|email',
            'cpf' => 'required|min:11|max:11',
            'birthday' => 'required|date_format:Y/m/d|before:16 years ago',
            'password' => 'required|confirmed|min:4'
        ];
    }
}
