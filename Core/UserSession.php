<?php

namespace Core;

class UserSession extends AbstractSession implements SessionInterface
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

    public function getVariable($name)
    {
        return $this->session[$name];
    }

    public function isVariableSet($name)
    {
        return isset($this->session[$name]);
    }
}
