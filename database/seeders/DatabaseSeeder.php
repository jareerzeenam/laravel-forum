<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TopicSeeder::class);

        $topics = Topic::all();

        $users = User::factory(10)->create();

        $posts = Post::factory(200)
            ->withFixture()
            ->has(Comment::factory(15)->recycle($users))
            ->recycle([$users, $topics])
            ->create();

        $jareer = User::factory()
             ->has(Post::factory(45)->recycle($topics)->withFixture())
             ->has(Comment::factory(120)->recycle($posts))
             ->create([
             'name' => 'Jareer Zeenam',
             'email' => 'jareer@gmail.com',
             'password' => bcrypt('123'),
        ]);
    }
}
