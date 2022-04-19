<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    private $table = 'slider';
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

        $condThumb = 'bail|required|image|max:1000';
        $condName = "bail|required|between:5,100|unique:$this->table,name";
        if (!empty($id)) {
            $condThumb = 'bail|image|max:1000';
            $condName .= ",$id";
        }
        return [
            'name'          => $condName,
            'description'   => 'bail|required',
            'link'          => 'bail|required|min:5|url',
            'status'        => 'bail|in:active, inactive',
            'thumb'         =>  $condThumb
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name không được rỗng',
            'name.min' => 'Name :input chiều dài phải có ít nhất :min giá trị',
        ];
    }
    public function attributes()
    {
        return [
            'description' => 'Description',
        ];
    }
}
