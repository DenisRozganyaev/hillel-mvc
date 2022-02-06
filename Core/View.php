<?php

namespace Core;

class View
{
    protected static $viewPath = '/App/Views/';

    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = BASE_DIR . static::$viewPath . $view . '.php';

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("{$file} not found");
        }
    }
}