<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function create(User $user)
    {
        return in_array($user->role, [
            User::ROLE_ADMIN,
            User::ROLE_EDITOR
        ]);
    }

    public function update(User $user, Post $post)
    {
        return in_array($user->role, [
            User::ROLE_ADMIN,
            User::ROLE_EDITOR
        ]) && $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        return $user->role === User::ROLE_ADMIN;
    }

    public function view(User $user, Post $post)
    {
        return true;
    }
}
