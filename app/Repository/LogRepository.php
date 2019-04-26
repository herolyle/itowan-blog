<?php
namespace App\Repository;

use App\Model\Log;
use Bosnadev\Repositories\Eloquent\Repository;

class LogRepository extends Repository
{
    public function model()
    {
        return Log::class;
    }

}