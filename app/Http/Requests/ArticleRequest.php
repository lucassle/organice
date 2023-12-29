<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest {
    private $table  = 'article';   
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
        $condTitle       = "bail|required|between:5,100";
        if (!empty($this->id)) {
            $condTitle       .= ",$this->id";
        }

        return [
            'title'          => $condTitle,
            // 'status'        => 'bail|in:active,inactive',
        ];
    }

    public function message () {
        return [
        ];
    }
}
