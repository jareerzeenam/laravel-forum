<?php

namespace Database\Factories;

use App\Models\User;
use App\Support\PostFixtures;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use SplFileInfo;
use function collect;
use function database_path;
use function dd;
use function fake;
use function str;
use const PHP_EOL;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => str(fake()->sentence)->beforeLast('.')->title(),
            'body' => Collection::times(4, fn() => fake()->realText(1250))->join(PHP_EOL . PHP_EOL),
        ];
    }

    public function withFixture(): static
    {

        return $this->sequence(...PostFixtures::getFixture());

    }

}

