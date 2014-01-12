<?php

namespace Core;

abstract class AbstractSession implements SessionInterface
{
    abstract public function getVariable($key);
    abstract public function setVariable($key, $value);
    abstract public function isVariableSet($key);

    public function getUser()
    {
        if ($this->isVariableSet('userName') && $this->isVariableSet('password')) {
            $user = new User();
            $user->logIn($this->getVariable('userName'), $this->getVariable('password'));
            $this->setVariable('user', $user);
            return $user;
        }

        return null;
    }
}
