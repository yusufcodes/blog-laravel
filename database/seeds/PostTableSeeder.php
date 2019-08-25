<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new \App\Post(
            [
                'title' => "This is a new seeded post!",
                'content' => "Here is some content for this post..."
            ]
        );
        $post->save();
    }
}
