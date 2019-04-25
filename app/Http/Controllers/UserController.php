<?php

namespace App\Http\Controllers;

use App\Repositories\Criteria\UserCriteria;
use App\Repository\UserRepository;

class UserController extends Controller
{
    private $user;
    private $count;

    public function __construct(UserRepository $user) {
        $this->user = $user;
        $this->user->pushCriteria(new UserCriteria());
    }

    /**
     * @return bool
     * 如果是超级管理员，可以显示管理页面链接（前端页面根据user数量是1还是大于1来显示）
     */
    public function index() {
        $count  = count($this->user->all());
        return view('welcome', ['isSuper' => $count]);
    }

    /**
     * @return mixed
     * 超级管理员返回所有用户，普通会员只有自己
     */
    public function superAdmin() {
        $user = $this->user->all(['id', 'name', 'role']);
        return view('user', ['user' => $user]);
    }
}
