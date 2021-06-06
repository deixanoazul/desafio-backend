<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules (): array {
        return [
            'name' => 'string|required',
            'cpf' => 'string|required',
            'email' => 'email|required',
            'birthdate' => 'date|required',
            'balance' => 'integer|required',
            'password' => 'string|min:8|required',
        ];
    }
}
