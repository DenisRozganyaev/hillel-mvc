<?php

namespace Core;

class Controller
{
    protected $validation = "";

    public function __call($name, $args)
    {
        $args = $args[0] ?? $args;

        if ($this->before($name)) {
            call_user_func_array([$this, $name], $args);
            $this->after();
        } else {
            throw new \Exception($this->validation);
        }
    }

    protected function before($actionName)
    {
        return true;
    }

    protected function after() {}
}