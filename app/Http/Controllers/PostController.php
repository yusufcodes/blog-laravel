<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\Tag;
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
        $post = Post::where('id', $id)->with('likes')->first();
        return view('blog.post', ['post' => $post]);
    }

    public function getLikePost($id)
    {
        $post = Post::find($id);
        $like = new Like();
        $post->likes()->save($like);

        return redirect()->back();
    }

    public function getAdminCreate()
    {
        $tags = Tag::all();
        return view('admin.create', ['tags' => $tags]);
    }

    public function getAdminEdit($id)
    {
        $post = Post::find($id);
        $tags = Tag::all();
        return view('admin.edit', ['post' => $post, 'postId' => $id, 'tags' => $tags]);
    }

    public function postAdminCreate(Request $request)
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

        // Associating any tags selected by the user to the new post being created
        $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));
        
        return redirect()
        ->route('admin.index')
        ->with('info', 'Post created, Title is: ' . $request->input('title'));
    }

    public function postAdminUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);

        $post = Post::find($request->input('id'));
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        // $post->tags()->detach();
        // $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));

        // Sync will update the tags according to the tags passed in, removing any old ones, and adding new ones
        $post->tags()->sync($request->input('tags') === null ? [] : $request->input('tags'));

        return redirect()
        ->route('admin.index')
        ->with('info', 'Post edited, Title is: ' . $request->input('title'));
    }

    public function getAdminDelete($id)
    {
        $post = Post::find($id);
        $post->likes()->delete();
        $post->tags()->detach();
        $post->delete();

        return redirect()
        ->route('admin.index')
        ->with('info', 'Post has been deleted');
    }
}
