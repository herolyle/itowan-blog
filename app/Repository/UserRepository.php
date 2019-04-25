<?php
namespace App\Repository;

use App\Model\User;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends Repository {
    public function model() {
        return User::class;
    }

    public function superManager($loginUser) {
        if ($loginUser && $loginUser->role == 0) {
            return true;
        }
        return false;
    }

    /**
     * @param $loginUser
     * @return User[]|Collection
     * 超级管理员获取所有作者id和name, 普通成员返回自己的id和name
     */
    public function getPoster ($loginUser) {
        if ($loginUser->role == 0) {
            return User::all();
        }

        return new Collection([$loginUser]);
    }
}