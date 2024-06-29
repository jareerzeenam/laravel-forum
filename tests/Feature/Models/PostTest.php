<?php

use App\Models\Post;

it('uses title case for titles', function () {
    $post = Post::factory()->create([
        'title' => 'Hello, how are you?',
    ]);

    expect($post->title)->toBe('Hello, How Are You?');
});

it('can generate a route to show the post', function () {
    $post = Post::factory()->create();

    expect($post->showRoute())->toBe(route('posts.show', [$post, Str::slug($post->title)]));
});

it('can generate a route to show the post with additional parameters', function () {
    $post = Post::factory()->create();

    expect($post->showRoute(['page' => 2]))
        ->toBe(route('posts.show', [$post, Str::slug($post->title), 'page' => 2]));
});

it('generates the html', function () {
    $post = Post::factory()->make([
        'body' => '## Hello World',
    ]);

    $post->save();

    expect($post->html)->toEqual(str($post->body)->markdown());
});
