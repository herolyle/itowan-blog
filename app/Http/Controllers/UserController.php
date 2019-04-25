<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $user;

    public function __construct(UserRepository $user) {
        $this->user = $user;
    }

    /**
     * @return bool
     * 判断是否是超级管理员，如果是才可以继续执行后面的操作
     */
    public function index() {
        $isSuper = false;
        if (Auth::user() && $this->user->superManager(Auth::user())) {
            $isSuper = true;
        }
        return view('welcome', ['isSuper' => $isSuper]);

    }

    /**
     * @return mixed
     * 返回所有用户
     */
    public function superAdmin() {
        if (!$this->user->superManager(Auth::user())) {
            return view('error.error', ['message' => '没有权限']);
        }
        $user = $this->user->all(['id', 'name', 'role']);
        return view('user', ['user' => $user]);
    }

    /**
     * @param Request $request
     * @return mixed
     * 更新用户的role,普通用户role = 1,更新后role = 0,变成超级管理员
     */
    public function changeRole(Request $request) {
        $id = $request->post('id');
        $role = $this->user->find($id, 'role');
        return $this->user->update(['role' => abs($role - 1)], $id, 'id');
    }
}
