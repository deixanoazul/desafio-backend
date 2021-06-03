<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules () {
        return [
            'name' => 'string|required',
            'cpf' => 'string|required',
            'email' => 'email|required',
            'birthdate' => 'date|required',
            'password' => 'string|min:8|confirmed|required',
        ];
    }
}
