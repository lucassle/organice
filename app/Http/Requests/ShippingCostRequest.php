<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingCostRequest extends FormRequest {
    private $table  = 'shipping_cost';   
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
        $id                 = $this->id;

        $condProvince       = "bail|required|unique:$this->table,province";
        $condCost           = "bail|required";

        if (!empty($id)) $condProvince  = "";

        return [
            'province'      => $condProvince,
            'cost'          => $condCost,
            'status'        => "bail|in:active,inactive",
        ];
    }
}
