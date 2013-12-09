<?php

namespace Core;

class BaseModel
{
    protected $dbAdapter = null;

    protected $loaded = false;

    public function __construct()
    {
        $this->dbAdapter = MysqlAdapter::getInstance();
    }

    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }

    public function setLoaded($state)
    {
        $this->loaded = (bool) $state;
    }

    public function isLoaded()
    {
        return $this->loaded;
    }
}
