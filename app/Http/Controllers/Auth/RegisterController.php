<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
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
    public function index()
    {
        return view('auth.register');
    }

    /**
     * @param Request $request
     * @return mixed
     * 注册表单验证
     */
    protected function register(RegisterRequest $request)
    {

        $data = $request->post();
        $data['ip'] = '196.28.1.3';
        $checkResult = $this->checkUser($data);
        if (!$checkResult) {
            return view('error.error', ['message' => '一分钟内不允许多次注册']);
        }
        return $this->create($data);
    }


    /**
     * @param array $data
     * @return mixed
     * 创建用户,并缓存注册用户ip
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
        return response()->redirectTo('post');
    }

    /**
     * @param array $data
     * @return bool
     * 注册限制
     */
    protected function checkUser(array $data)
    {
        if (empty($data['ip'])) {
            abort(500);
        }
        if (Cache::has($data['ip'])) {
            return false;
        };
        return true;
    }
}
