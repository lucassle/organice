<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest {
    private $table  = 'coupon';   
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
        $type               = implode(',', array_keys(config('return.template.type_coupon_discount')));

        $condCode           = "bail|required|min:6|max:6|unique:$this->table,code";
        $condType           = "bail|in:$type";
        $condValue          = "bail|numeric|min:1";
        // $condEndTime        = "after_or_equal:" . date("Y-m-d s:i:H");
        $condStartPrice     = "bail|numeric|min:1";
        $condEndPrice       = "bail|numeric|min:1|gt:start_price";
        $condTotal          = "bail|numeric|min:1";

        if ($this->type == "percent" ) $condValue .= "|max:100";

        if (!empty($id)) $condCode  = "";

        return [
            'code'          => $condCode,
            'type'          => $condType,
            'value'         => $condValue,
            // 'end_time'      => $condEndTime,
            'start_price'   => $condStartPrice,
            'end_price'     => $condEndPrice,
            'total'         => $condTotal,
            'status'        => "bail|in:active,inactive",
        ];
    }
}
