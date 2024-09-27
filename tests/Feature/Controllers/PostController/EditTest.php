<?php

use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\get;


it('should return the correct component', function () {
    $post = Post::factory()->create();

//     TODO:
    get(route('posts.edit', $post))
        ->assertComponent('Posts/Edit');
});
