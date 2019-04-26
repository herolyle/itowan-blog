<?php

namespace App\Providers;

use App\Model\Post;
use App\Observers\PostObserver;
use App\Repositories\Criteria\RoleCriteria;
use App\Tool\LogStore;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     *
     * 注入统一的权限RoleCriteria
     */
    public function boot()
    {
        Post::observe(PostObserver::class);

        $this->app->afterResolving(Repository::class, function(Repository $object, $app) {
            $object->pushCriteria($app->make(RoleCriteria::class));
        });
        $this->app->singleton(LogStore::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
    }
}
