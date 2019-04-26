<?php

namespace App\Observers;

use App\Model\Post;
use App\Repository\LogRepository;
use App\Tool\LogStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostObserver
{
    protected $log;
    protected $request;
    protected $logStore;
    public function __construct(LogRepository $log, Request $request, LogStore $logStore)
    {
        $this->log = $log;
        $this->request = $request;
        $this->logStore = $logStore;
    }

    /**
     * @param Post $post
     * 更新记录
     */
    public function updated(Post $post)
    {
        $change = $post->getDirty();
        $old = $post->getOriginal();
        $data = [
            'user_id' => Auth::user()->id,
            'email' => Auth::user()->email,
            'ip' => $this->request->getClientIp(),
            'type' => 3,
            'change_content' => json_encode([$change, $old]),
        ];
        $this->logStore->add($data);
    }

    /**
     * @param Post $post
     * 新增记录
     */
    public function created(Post $post)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'email' => Auth::user()->email,
            'ip' => $this->request->getClientIp(),
            'type' => 4,
            'change_content' => json_encode($post),
        ];
        $this->logStore->add($data);
    }

    /**
     * @param Post $post
     * 删除记录
     */
    public function deleting(Post $post)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'email' => Auth::user()->email,
            'ip' => $this->request->getClientIp(),
            'type' => 5,
            'change_content' => json_encode($post),
        ];
        $this->logStore->add($data);
    }
}