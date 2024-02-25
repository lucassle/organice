<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
    private $table  = 'user';   
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Validation\Rule|array|string>
     */
    public function rules(): array {
        return [
            "username"          => "bail|required|between:4,100|unique:$this->table,username",
            "fullname"          => "bail|required|between:4,100",
            "email"             => "bail|required|email:rfc,dns|unique:$this->table,email",
            "password"          => "bail|required|between:6,32|confirmed",
        ];
    }
}
