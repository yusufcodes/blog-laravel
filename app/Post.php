<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = ['title', 'content'];

    // Retrieve all posts
    public function getPosts($session)
    {
        if (!$session->has('posts'))
        {
            $this->createDummyData($session);
        }
        return $session->get('posts');
    }

    // Retrieve a single post
    public function getPost($session, $id)
    {
        if (!$session->has('posts'))
        {
            $this->createDummyData();
        }

        return $session->get('posts')[$id];
    }

    public function addPost($session, $title, $content)
    {
        if (!$session->has('posts'))
        {
            $this->createDummyData();
        }

        $posts = $session->get('posts');
        array_push($posts, ['title' => $title, 'content' => $content]);
        $session->put('posts', $posts);
    }

    public function editPost($session, $id, $title, $content)
    {
        $posts = $session->get('posts');
        $posts[$id] = ['title' => $title, 'content' => $content];
        $session->put('posts', $posts);
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