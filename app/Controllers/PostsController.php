<?php

namespace App\Controllers;

use App\Models\Post;

class PostsController
{

    public function index()
    {
        $post = Post::find(8);

        $post = $post->update(['title' => 'Hillel 2']);

        dd($post);
    }

    #  GET posts/ - index
    #  GET posts/create - create
    #  GET posts/:id - show
    #  GET posts/:id/edit - edit
    #  POST posts/ - store
    #  POST posts/:id - update
    #  POST posts/:id/destroy - delete/destroy(+)

    public function show(int $id)
    {
        $post = Post::find($id);

        dd($post);
    }
}