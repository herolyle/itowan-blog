<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|max:16',
            'email' => 'email|unique:user',
            'password' => 'required|',
            'password_confirmation' => 'required|same:password',
            'captcha' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'name.max'=> trans("昵称过长"),
            'email.unique'=> trans("email已经注册"),
            'password.required'=> trans("密码不能为空"),
            'password_confirmation.required'=> trans("确认密码不能为空"),
            'password_confirmation.same'=> trans('密码与确认密码不匹配'),
            'captcha.required' => trans('请填写验证码'),
            'captcha.captcha' => trans('验证码错误'),
        ];
    }
}
