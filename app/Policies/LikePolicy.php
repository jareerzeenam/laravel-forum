<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use function dd;
use function in_array;

class LikePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Model $likeable): bool
    {
        if (! in_array($likeable::class, [Post::class, Comment::class])){
            return false;
        }
        return $likeable->likes()->whereBelongsTo($user)->doesntExist();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Model $likeable): bool
    {
        if (! in_array($likeable::class, [Post::class, Comment::class])){
            return false;
        }
        return $likeable->likes()->whereBelongsTo($user)->exists();
    }
}
