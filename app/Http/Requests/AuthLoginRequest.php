<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    private $table = 'user';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $task = $this->task;
        $condUsername       = '';
        $condEmail          = '';
        $condPass           = '';
        switch ($task) {
            case 'login':
                $condEmail      = "bail|required|email";
                $condPass       = 'bail|required|between:5,100';
                break;
            case 'register':
                $condUsername   = "bail|required|between:5,100|unique:$this->table,username";
                $condEmail      = "bail|required|between:5,100|unique:$this->table,email";
                $condPass       = 'bail|required|between:5,100';
                break;
        }

        return [
            'username'       =>   $condUsername,
            'email'          =>   $condEmail,
            'password'       =>   $condPass,
        ];
    }
    public function messages()
    {
        return [
            /*  'username.required' => 'Username không được rỗng',
            'username.min' => 'Username :input chiều dài phải có ít nhất :min giá trị', */];
    }
    public function attributes()
    {
        return [
            /* 'description' => 'Description', */];
    }
}
