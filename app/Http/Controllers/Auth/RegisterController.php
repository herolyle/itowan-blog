<?php

namespace App\Http\Controllers\Auth;

use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 注册页面
     */
    public function index() {
        return view('auth.register');
    }

    /**
     * @param Request $request
     * @return mixed
     * 注册表单验证
     */
    protected function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:16',
            'email' => 'email|unique:user',
            'password' => 'required|',
            'password_confirmation' => 'required|same:password',
            'captcha' => 'required|captcha',
        ],[
            'name.max'=> trans("昵称过长"),
            'email.unique'=> trans("email已经注册"),
            'password.required'=> trans("密码不能为空"),
            'password_confirmation.required'=> trans("确认密码不能为空"),
            'password_confirmation.same'=> trans('密码与确认密码不匹配'),
            'captcha.required' => trans('请填写验证码'),
            'captcha.captcha' => trans('验证码错误'),
        ]);
        $data = $request->post();
        $data['ip'] = $request->getClientIp();
        $this->checkUser($data);

        return $this->create($data);
    }


    /**
     * @param array $data
     * @return mixed
     * 创建用户
     */
    protected function create(array $data)
    {
        $user = $this->user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 1,
            'recent_ip' => $data['ip']
        ]);
        if ($user) {
            Cache::put($data['ip'], '1', 1);
        }
        Auth::login($user);
        return response()->view('home');
    }

    protected function checkUser(array $data) {
        if (empty($data['ip'])) {
            abort(500);
        }

        if (Cache::has($data['ip'])) {
            return response()->view('errors.error', [], 403);
        };
    }
}
