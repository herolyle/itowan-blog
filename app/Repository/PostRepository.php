<?php
namespace App\Repository;

use App\Model\Post;
use App\Model\User;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Database\Eloquent\Collection;

class PostRepository extends Repository {
    public function model() {
        return Post::class;
    }

    public function isSuperUser($loginUser) {
        if ($loginUser->role == 0) {
            return true;
        }
        return false;
    }
    /**
     * @param $post
     * @param $loginUser
     * @return bool
     */
    public function checkPostUser($post, $loginUser) {
        if ($loginUser->role !== 0 && $loginUser->id !== $post->user_id) {
            return false;
        }
        return true;
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

    /**
     * @param $column
     * @param $value
     * @param int $perPage
     * @param array $columns
     * @return mixed
     * 分页
     */
    public function paginateBy($column, $value, $perPage = 10, $columns = array('*')) {
        return $this->model->where($column, $value)->paginate($perPage, $columns);
    }
}