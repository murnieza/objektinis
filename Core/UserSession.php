<?php

namespace Core;

class UserSession
{
    private $session = null;

    public function __construct()
    {
        $this->session = &$_SESSION;
    }

    public function setVariable($name, $value)
    {
        $this->session[$name] = $value;
    }

    public function getUser()
    {
        if (isset($this->session['userName']) && isset($this->session['password'])) {
            $this->session['user'] = new User();
            $this->session['user']->logIn($this->session['userName'], $this->session['password']);
            return $this->session['user'];
        }

        return null;
    }
}