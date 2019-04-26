<?php

namespace App\Http\Controllers\Auth;

use App\Events\LogEvent;
use App\Http\Controllers\Controller;
use App\Listeners\LogEventListener;
use App\Repository\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $user;
    public $maxAttempts = 2;
    public $decayMinutes = 10;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/post';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 登录页面
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     * 登录验证
     */
    public function login(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            return view('error.error', ['message' => '密码错误次数过多']);
        } else {
            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];
            $rightUser = Auth::attempt($data);
            if ($rightUser) {
                event(new LogEvent($request, Auth::guard()->user()));
                return redirect($this->redirectTo);
            } else {
                event(new LogEvent($request));
                return view('error.error', ['message' => '密码错误']);
            }
        }
    }


    /**
     * @return \Illuminate\Http\Response
     * 退出登录
     */
    public function logout()
    {
        Auth::logout();
        return response()->view('auth.login');
    }
}
