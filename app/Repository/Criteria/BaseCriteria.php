<?php
namespace App\Repositories\Criteria;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class BaseCriteria extends Criteria
{

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     * 一些全局的域处理可以在这里写，然后在AppServiceProvider里面全局注入（这样后续的所有model数据都建立在这里的查询之上）
     */
    public function apply($model, Repository $repository)
    {
    }
}