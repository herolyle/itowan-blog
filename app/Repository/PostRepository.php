<?php
namespace App\Repository;

use App\Model\Post;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;

class PostRepository extends Repository {
    public function model() {
        return Post::class;
    }
}