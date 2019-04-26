<?php

namespace App\Policies;

use App\Model\User;
use App\Model\post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\Model\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        if ($user->role == 0) {
            return true;
        }
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        if ($user->role == 0) {
            return true;
        }
        return $user->id === $post->user_id;
    }
}
