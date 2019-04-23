<?php

namespace App\Http\Controllers\Auth;

use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

//    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('guest');
        $this->user = $user;
    }

    public function index() {
        return view('auth.register');
    }

    /**
     * @param Request $request
     * @return User
     */
    protected function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:16',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'captcha' => 'required|captcha',
        ],[
            'name.max'=> trans("昵称过长"),
            'password.required'=> trans("密码不能为空"),
            'password_confirmation.required'=> trans("确认密码不能为空"),
            'password_confirmation.same'=> trans('密码与确认密码不匹配'),
            'captcha.required' => trans('请填写验证码'),
            'captcha.captcha' => trans('验证码错误'),
        ]);
        $data = $request->post();
        $data['ip'] = $request->ip();
        return $this->create($data);
    }


    /**
     * @param array $data
     * @return mixed
     */
    protected function create(array $data)
    {
        return $this->user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 1,
            'recent_ip' => $data['ip']
        ]);

    }
}
