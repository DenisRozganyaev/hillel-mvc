<?php

namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use Core\View;

class HomeController extends Controller
{

    protected function index()
    {
        $user = User::select(['first_name']);
        dd($user->where(['email', '=', 'test@test.com']));
        View::render('home/index');
    }

}