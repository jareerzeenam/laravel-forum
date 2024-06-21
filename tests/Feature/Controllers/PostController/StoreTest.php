<?php

use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->validData = [
        'title' => 'Hello World',
        'body' => 'This is my very first post!'
    ];
});

it('requires authentication', function () {
    post(route('posts.store'))
        ->assertRedirect(route('login'));
});

it('stores a post', function () {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), $this->validData);

    $this->assertDatabaseHas(Post::class,[
        ...$this->validData,
        'user_id' => $user->id,
    ]);
});

it('redirects to the post show page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('posts.store'), $this->validData)
        ->assertRedirect(route('posts.show', Post::latest('id')->first()));
});

it('requires a valid title', function ($badTitle) {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), [
        ...$this->validData,
        'title' => $badTitle,
    ])->assertInvalid('title');

})->with([
    null,
    true,
    1,
    1.0,
    str_repeat('a', 121),
    str_repeat('a', 9),
]);

it('requires a valid body', function ($badBody) {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), [
        ...$this->validData,
        'body' => $badBody,
    ])->assertInvalid('body');

})->with([
    null,
    true,
    1,
    1.5,
    str_repeat('a', 9),
    str_repeat('a', 10001),
]);
