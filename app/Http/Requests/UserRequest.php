<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->id;
        $task = $this->task;

        $condAvatar         = '';
        $condUsername       = '';
        $condEmail          = '';
        $condPass           = '';
        $condLevel          = '';
        $condStatus         = '';
        $condFullname       = '';


        switch ($task) {
            case 'add':
                $condAvatar     = 'bail|required|image|max:100';
                $condUsername   = "bail|required|between:5,100|unique:$this->table,username";
                $condEmail      = "bail|required|between:5,100|unique:$this->table,email";
                $condPass       = 'bail|required|between:5,100|confirmed';
                $condLevel      = 'bail|in:admin,member';
                $condStatus     = 'bail|in:active,inactive';
                $condFullname   = 'bail|required|min:5';
                break;

            case 'edit-info':
                $condAvatar     = 'bail|required|image|max:100';
                $condUsername   = "bail|required|between:5,100|unique:$this->table,username";
                $condEmail      = "bail|required|between:5,100|unique:$this->table,email";
                $condFullname   = 'bail|required|min:5';
                $condStatus     = 'bail|in:active,inactive';
                break;

            case 'change-password':
                $condPass       = 'bail|required|between:5,100|confirmed';
                break;

            case 'change-level':
                $condLevel      = 'bail|in:admin,member';
                break;

            default:
                break;
        }

        return [
            'username'          => $condUsername,
            'email'             =>  $condEmail,
            'fullname'          =>  $condFullname,
            'status'            =>  $condStatus,
            'level'             =>  $condLevel,
            'avatar'            =>  $condAvatar,
            'password'          =>  $condPass
        ];
    }
    public function messages()
    {
        return [
            'username.required' => 'Username không được rỗng',
            'username.min' => 'Username :input chiều dài phải có ít nhất :min giá trị',
        ];
    }
    public function attributes()
    {
        return [
            'description' => 'Description',
        ];
    }
}
