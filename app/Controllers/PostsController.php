<?php

namespace App\Controllers;

use App\Models\Post;
use Core\Controller;

class PostsController extends Controller
{

    protected function index()
    {
    }

    #  GET posts/ - index
    #  GET posts/create - create
    #  GET posts/:id - show
    #  GET posts/:id/edit - edit
    #  POST posts/ - store
    #  POST posts/:id - update
    #  POST posts/:id/destroy - delete/destroy(+)

    protected function show(int $id)
    {
    }
}