<?php
namespace App\Repository;

use App\Model\User;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;

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
}