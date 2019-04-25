<?php
namespace App\Repository;

use App\Model\Post;
use Bosnadev\Repositories\Eloquent\Repository;

class PostRepository extends Repository {
    public function model() {
        return Post::class;
    }

    public function boot(){
        $this->pushCriteria(app('App\Repositories\Criteria\PostCriteria'));
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

    /**
     * @param $search
     * @return mixed
     * 根据标题或作者查询文章
     */
    public function searchPost($search) {
        return Post::where([['title', 'like', '%' . $search . '%']])->orWhereHas('user', function ($query) use ($search) {
            $query->where([['name', 'like', '%' . $search . '%']]);
        })->paginate(10);
    }
}