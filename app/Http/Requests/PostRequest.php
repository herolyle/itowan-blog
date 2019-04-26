<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
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
        return [
            'title' => 'required|max:40',
            'describe' => 'required|max:150',
        ];
    }

    public function messages()
    {
        return [
            'title.max'=> trans("标题过长"),
            'describe.max'=> trans("简介过长"),
            'title.required'=> trans("标题不能为空"),
            'describe.required'=> trans("标题不能为空"),
        ];
    }
}
