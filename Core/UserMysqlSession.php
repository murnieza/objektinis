<?php

namespace Core;

class UserMysqlSession extends AbstractSession implements SessionInterface
{
    /** @var \Core\MysqlAdapter|null */
    protected $adapter = null;

    public function __construct()
    {
        $this->adapter = MysqlAdapter::getInstance();
    }

    public function setVariable($name, $value)
    {
        $this->adapter->makeQuery("INSERT INTO sessions SET name='?', value='?'", array($name, $value));
    }

    public function getVariable($name)
    {
        return $this->adapter->makeQuery("SELECT value FROM sessions WHERE name='?'", array($name));
    }

    public function isVariableSet($name)
    {
        return $this->adapter->queryCount("SELECT COUNT(*) FROM sessions WHERE name='?'", array($name)) > 0;
    }
}
