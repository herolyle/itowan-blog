<?php
namespace App\Repository;

use App\Model\Post;
use Bosnadev\Repositories\Eloquent\Repository;

class PostRepository extends Repository {
    public function model() {
        return Post::class;
    }

    protected $searchable = [
        'title' => 'like',
    ];

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