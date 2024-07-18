<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class LikeFactory extends Factory
{

    // This is having a connection with APPServiceProvider.php Relation::enforceMorphMap method
    public function definition(): array
    {
        return [
            'user_id' => User::factory(['email' => 'test+'. Str::uuid() . '@example.com']),
            'likeable_type' => $this->likeableType(...),
            'likeable_id' => Post::factory(),
        ];
    }

    protected function likeableType(array $values)
    {
        $type = $values['likeable_id'];
        $modelName = $type instanceof Factory
            ? $type->modelName()
            : $type::class;

        return (new $modelName)->getMorphClass();
    }
}
