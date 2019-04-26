<?php
namespace App\Repository;

use App\Model\User;
use Bosnadev\Repositories\Eloquent\Repository;

class UserRepository extends Repository
{
    public function model()
    {
        return User::class;
    }
}