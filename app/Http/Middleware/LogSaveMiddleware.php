<?php

namespace App\Http\Middleware;

use Closure;
use App\Tool\LogStore;

class LogSaveMiddleware {
    /**
     * @var LogStore
     * 获取LogStore实例，在http请求完成后从内存中拿取数据，并保存到database
     */
    protected $log;
    public function __construct(LogStore $logStore) {
        $this->log = $logStore;
    }

    public function handle($request, Closure $next) {
        return  $next($request);
    }

    public function terminate($request, $response) {
        $this->log->save();
    }

}