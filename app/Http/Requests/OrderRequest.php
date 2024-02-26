<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest {
    private $table  = 'cart';   
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
        $condName       = "bail|required|between:5,100|unique:$this->table,name";
        $condThumb      = 'bail|required|image';
        if (!empty($this->id)) {
            $condThumb      = 'bail|image';
            $condName       = "bail|required|between:5,100|unique:$this->table,name,$this->id";
        }

        return [
            'name'          => $condName,
            'description'   => 'bail|required|min:10',
            'link'          => 'bail|required|url',
            'status'        => 'bail|in:active,inactive',
            'thumb'         => $condThumb
        ];
    }

    public function message () {
        return [
            'name.required'         => 'Name field is required',
            'name.min'              => 'Name is least at :min character',
            'description.required'  => 'Description field is required',
            'link.required'         => 'Link field is required',
        ];
    }
}
