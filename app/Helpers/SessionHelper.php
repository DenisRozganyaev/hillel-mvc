<?php

namespace App\Helpers;

class SessionHelper
{
    public static function isUserLoggedIn(): bool
    {
        return !empty($_SESSION['user_data']);
    }

    public static function getUserId()
    {
        return $_SESSION['user_data']['id'];
    }

    public function setUserData($id, $email = null, ...$args)
    {
        $_SESSION['user_data'] = array_merge([
            'id' => $id,
            'email' => $email
        ], $args);
    }

    public static function destroyUserData()
    {
        session_destroy();
    }
}
