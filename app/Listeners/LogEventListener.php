<?php

namespace App\Listeners;

use App\Events\LogEvent;
use App\Repository\LogRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogEventListener
{
    private $log;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LogRepository $log)
    {
        $this->log = $log;
    }

    /**
     * Handle the event.
     *
     * @param  logEvent  $event
     * @return void
     */
    public function handle(LogEvent $event)
    {
        $user = $event->user;
        $request = $event->request;
        $this->loginLog($user, $request);
    }

    /**
     * @param $user
     * @param $request
     */
    public function loginLog($user, $request) {
        if ($user) {
            $userId = $user->id;
            $email = $user->email;
            $change_content = '登录成功';
            $type = 1;
        } else {
            $userId = 0;
            $email = $request->post('email');
            $change_content = '登录失败';
            $type = 2;
        }
        $data = [
            'user_id' => $userId,
            'email' => $email,
            'ip' => $request->getClientIp(),
            'type' => $type,
            'change_content' => $change_content,
        ];
        $this->log->create($data);
    }
}
