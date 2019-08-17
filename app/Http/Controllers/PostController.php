<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

// Sessions
use Illuminate\Session\Store;

use App\Http\Requests;

class PostController extends Controller
{
    public function getIndex()
    {
        $posts = Post::all();
        return view('blog.index', ['posts' => $posts]);
    }

    public function getAdminIndex()
    {
        $posts = Post::all();
        return view('admin.index', ['posts' => $posts]);
    }

    public function getPost($id)
    {
        $post = Post::find($id);
        return view('blog.post', ['post' => $post]);
    }

    public function getAdminCreate()
    {
        return view('admin.create');
    }

    public function getAdminEdit($id)
    {
        $post = Post::find($id);
        return view('admin.edit', ['post' => $post, 'postId' => $id]);
    }

    public function postAdminCreate(Store $session, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);

        // Create a new instance of the Post model, and populate the title and content fields
        // Passing in an associative array with the field names works because of the $fillable protected field defined in the model
        $post = new Post([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);

        // Eloquent method to execute queries to the database linked to the model
        $post->save();
        
        return redirect()
        ->route('admin.index')
        ->with('info', 'Post created, Title is: ' . $request->input('title'));
    }

    public function postAdminUpdate(Store $session, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);

        $post = Post::find($request->input('id'));
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        
        return redirect()
        ->route('admin.index')
        ->with('info', 'Post edited, Title is: ' . $request->input('title'));
    }
}
