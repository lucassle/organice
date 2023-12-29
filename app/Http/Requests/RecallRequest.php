<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecallRequest extends FormRequest {
    private $table  = 'recall';   
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
        $condPhoneNumber    = 'bail|required|numeric|between:10,16';
        return [
            'phone_number'      => $condPhoneNumber,
        ];
    }
}
