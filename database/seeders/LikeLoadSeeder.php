<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;
use function Laravel\Prompts\progress;

class LikeLoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * this is a chunk seeder that will create 500,000 likes for the first post
     */
    public function run(): void
    {
        $post = Post::find(1);

        $progress = progress(label:'Creating likes', steps: 500_000);

        $progress->start();
        LazyCollection::times(5000)->each(function () use ($post, $progress) {
            Like::factory(100)->for($post, 'likeable')->create();
            $progress->advance(100);
        });
        $progress->finish();

        $post->increment('likes_count', 500_000);
    }
}
