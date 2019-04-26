<?php
namespace App\Repositories\Criteria;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Illuminate\Support\Facades\Auth;

class PostCriteria extends Criteria
{

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository) {
        $user = Auth::user();
        if ($user && $user->role == 0) {
            return $model;
        }
        return $model->where('user_id', $user->id);
    }
}