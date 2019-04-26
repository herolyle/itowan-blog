<?php
namespace App\Repository;

use App\Model\Post;
use Bosnadev\Repositories\Eloquent\Repository;

class PostRepository extends Repository
{
    public function model()
    {
        return Post::class;
    }

    protected $searchable = [
        'id',
        'title' => 'like',
    ];
}