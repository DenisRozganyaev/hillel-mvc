<?php

$router->add('', ['controller' => 'HomeController', 'action' => 'index', 'method' => 'GET']);

$router->add('posts', ['controller' => 'PostsController', 'action' => 'index', 'method' => 'GET']);

# GET
$router->add('posts/{id:\d+}', ['controller' => 'PostsController', 'action' => 'show', 'method' => 'GET']);
$router->add('posts/{id:\d+}/update', ['controller' => 'PostsController', 'action' => 'update', 'method' => 'POST']);

$router->add('login', ['controller' => 'AuthController', 'action' => 'login', 'method' => 'GET']);
$router->add('registration', ['controller' => 'AuthController', 'action' => 'register', 'method' => 'GET']);

$router->add('user/store', ['controller' => 'UsersController', 'action' => 'store', 'method' => 'POST']);
