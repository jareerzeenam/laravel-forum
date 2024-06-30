<?php

namespace Database\Factories;

use App\Models\User;
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
        $posts = static::getFixture()
            ->map(fn(string $contents) => str($contents)->explode("\n", 2))
            ->map(fn(Collection $parts) => [
                'title' => str($parts[0])->trim()->after('# '),
                'body' => str($parts[1])->trim(),
        ]);

        return $this->sequence(...$posts);

    }

    private static function getFixture(): Collection
    {
        return collect(File::files(database_path('factories/fixtures/posts')))
            ->map(fn(SplFileInfo $fileInfo) => $fileInfo->getContents());
    }
}

