<?php

namespace App;

class Post
{
    public function getPosts($session)
    {
        if (!$session->has('posts'))
        {
            $this->createDummyData($session);
        }
        return $session->get('posts');
    }

    private function createDummyData($session)
    {
        $posts = [
            [
                'title' => 'Hello Laravel',
                'content' => 'This is one of the blog posts...'
            ],

            [
                'title' => 'Laravel Post Two',
                'content' => 'This is another blog post...'
            ]

        ];

        $session->put('posts', $posts);
    }
}