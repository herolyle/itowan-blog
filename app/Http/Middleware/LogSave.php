<?php

namespace App\Http\Middleware;

use App\Repository\LogRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class LogSave
{

    protected $log;

    public function __construct(LogRepository $log) {
        $this->log = $log;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * 表单提交日志记录，非登录页面的提交日志类型type = 0
     */
    public function handle($request, Closure $next)
    {
        $input = $request->url();
        $strUrl = substr($input, strrpos($input, '/'));
        if('GET' !== $request->method() && '/login' !== $strUrl && '/register' !== $strUrl){
            $this->log->create([
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'ip' => $request->getClientIp(),
                'type' => 0,
                'change_content' => json_encode($request->post()),
            ]);
        }

        $response = $next($request);
        return $response;

    }

    /**
     * @param $request
     * @param $response
     * 登录页面，登录成功日志类型type = 1
     * 登录页面，登录失败日志类型type = 2
     */
    public function terminate($request, $response) {
        $strUrl = substr($request->url(), strrpos($request->url(), '/'));
        if ('GET' !== $request->method()) {
            if (Auth::check() && '/login' == $strUrl) {
                $type = 1;
                $user_id =  Auth::user()->id;
                $change = '登录成功';
            }
            if (!Auth::check() && '/login' == $strUrl) {
                $type = 2;
                $user_id =  0;
                $change = '登录失败';
            }
            $data = [
                'user_id' => $user_id,
                'email' => $request->get('email'),
                'ip' => $request->getClientIp(),
                'type' => $type,
                'change_content' => $change
            ];
            $this->log->create($data);
        }
    }

}
