<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest {
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
            'email'             => 'bail|required|email',
            'password'          => 'bail|required|between:6,32',
        ];
    }
}
