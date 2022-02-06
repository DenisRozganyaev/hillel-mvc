<?php

namespace App\Controllers;

use Core\View;

class AuthController
{
    public function login()
    {
        View::render('auth/login');
    }

    public function register()
    {
        View::render('auth/register');
    }
}