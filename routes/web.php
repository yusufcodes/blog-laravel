<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Homepage
Route::get('/', ['as' => 'blog.index', function () {
    return view('blog.index');
}]);

/* Single post
Takes a single parameter, id, and uses this value to dynamically change the title and content of a post. */
Route::get('post/{id}', ['as' => 'blog.post', function ($id) {
    if ($id == 1)
    {
        $post = 
        [
            'title' => 'Learning Laravel',
            'content' => 'This blog post will get you right on track with Laravel!'
        ];
    }
    else
    {
        $post = 
        [
            'title' => 'Something else',
            'content' => 'Some other content'
        ];
    }
    
    /* The $post variable is sent back with the page to display this data onto,
    the title and contents. The contents of $post can then be accessed in the view. */
    return view('blog.post', ['post' => $post]);
}]);

// About
Route::get('about', ['as' => 'other.about', function () {
    return view('other.about');
}]);

// Admin routes
/* The group method is used to append the 'admin' route to all of the contained routes. This saves us from writing admin/create, admin/edit, etc. */
Route::group(['prefix' => 'admin'], function () {
    // Index
    Route::get('', ['as' => 'admin.index', function () {
        return view('admin.index');
    }]);
    
    // Create
    Route::get('create', ['as' => 'admin.create', function () {
        return view('admin.create');
    }]);
    
    /* Edit
    Takes a single parameter, id, and uses this value to dynamically change the title and content of a post. */
    Route::get('edit/{id}', ['as' => 'admin.edit', function ($id) {
        if ($id == 1)
        {
            $post = 
            [
                'title' => 'Learning Laravel',
                'content' => 'This blog post will get you right on track with Laravel!'
            ];
        }
        else {
            $post = 
            [
                'title' => 'Something else',
                'content' => 'Some other content'
            ];
        }
        
        return view('admin.edit', ['post' => $post]);
    }]);
    
    // Admin POST routes
    /* The following two POST routes take two arguments in their constructors: 
    1.\Illuminate\Http\Request $request
    Allows access to the HTTP request made to the route

    2.\Illuminate\Validation\Factory $validator
    Facade made to handle validation */

    // Create
    Route::post('create', ['as' => 'admin.create', function (\Illuminate\Http\Request $request,
    \Illuminate\Validation\Factory $validator) {
        /* Creating an instance of the Validator object, passing in all the data required from the request through the use of the all method. Associative array used to specify the rules of validation for each field. */
        $validation = $validator->make($request->all(), [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);

        /* Upon a failed validation, the user is sent back to the page that they came from with the errors appended to the request, which are then able to be displayed to the user. */
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation);
        }

        /* Sending the user back to the index page, showing that their update was successful using the with method to send back the data which they entered. */
        return redirect()
        ->route('admin.index')
        ->with('info', 'Post created, with Title: ' . $request->input('title'));
    }]);
    
    Route::post('edit', ['as' => 'admin.update', function (\Illuminate\Http\Request $request,
    \Illuminate\Validation\Factory $validator) {
        $validation = $validator->make($request->all(), [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation);
        }

        return redirect()
        ->route('admin.index')
        ->with('info', 'Post edited, new Title: ' . $request->input('title'));
    }]);
});