<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
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
        // $task       = $this->taskAdd;
        // $task       = 'add-item';
        if (isset($this->taskAdd))              $task = 'add-item';
        if (isset($this->taskInfo))             $task = 'edit-info';
        if (isset($this->taskChangePassword))   $task = 'change-password';
        if (isset($this->taskChangeLevel))      $task = 'change-level';

        $condUsername       = '';
        $condFullname       = '';
        $condEmail          = '';
        $condStatus         = '';
        $condLevel          = '';
        $condPassword       = '';
        $condAvatar         = '';

        switch ($task) {
            case 'add-item':
                $condUsername       = "bail|required|between:4,100|unique:$this->table,username";
                $condFullname       = "bail|required|between:4,100";
                $condEmail          = "bail|required|email:rfc,dns|unique:$this->table,email";
                $condStatus         = "bail|required|in:active,inactive";
                $condLevel          = "bail|required|in:admin,member";
                $condPassword       = "bail|required|between:6,32|confirmed";
                $condAvatar         = "bail|required|image|max:1000";
                break;
            case 'edit-info':
                $condUsername       = "bail|required|between:4,100|unique:$this->table,username,$this->id";
                $condFullname       = "bail|required|between:4,100";
                $condEmail          = "bail|required|email:rfc,dns|unique:$this->table,email,$this->id";
                $condStatus         = "bail|in:active,inactive";
                $condAvatar         = 'bail|image|max:1000';
                break;
            case 'change-password':
                $condPassword       = "bail|required|between:6,32|confirmed";
                break;
            case 'change-level':
                $condLevel          = "bail|required|in:admin,member";
                break;
        };
        return [
            'username'      => $condUsername,
            'fullname'      => $condFullname,
            'email'         => $condEmail,
            'status'        => $condStatus,
            'level'         => $condLevel,
            'password'      => $condPassword,
            'avatar'        => $condAvatar
        ];
    }

    public function message () {
        return [
            'name.required'         => 'Name field is required',
        ];
    }
}
