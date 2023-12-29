<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {
    private $table  = 'product';   
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
        // $condName       = "bail|required|between:5,100|unique:$this->table,name";
        // if (!empty($this->id)) {
        //     $condName       = "bail|required|between:5,100|unique:$this->table,name,$this->id";
        // }

        return [
            // 'name'          => $condName,
            // 'status'        => 'bail|in:active,inactive',
        ];
    }

    public function message () {
        return [
            'name.required'         => 'Name field is required',
        ];
    }
}
