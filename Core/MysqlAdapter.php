<?php

class MysqlAdapter
{
    protected $host = "localhost";
    protected $user = "root";
    protected $pass = "sudo";
    protected $database = "KTIT";

    protected $connection = null;
    protected static $instance = null;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new MysqlAdapter();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $link = mysqli_connect($this->host, $this->user, $this->pass);
        if (!$link) {
            die(mysql_error());
        }

        mysqli_select_db($link, $this->database);

        $this->connection = $link;
    }

    private function prepareArguments($arguments = array())
    {
        foreach($arguments as $key => $argument) {
            $argument = mysqli_real_escape_string($this->connection, $argument);

            $arguments[$key] = $argument;
        }
        return $arguments;
    }

    private function prepareQuery($query, $arguments = array())
    {
        $arguments = $this->prepareArguments($arguments);
        $query = vsprintf(str_replace("?", "%s", $query), $arguments);

        return $query;
    }

    public function makeQuery($query, $arguments = array())
    {
        $query = $this->prepareQuery($query, $arguments);
        $result = mysqli_query($this->connection, $query) ;
        return $result;
    }

    public function queryCount($query, $arguments = array()) {
        $result = $this->makeQuery($query, $arguments);
        if ($result) {
            return mysqli_num_rows($result);
        }
        return 0;
    }

    public function queryResults($query, $arguments = array())
    {
        $result = $this->makeQuery($query, $arguments);
        $results = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
        }
        return $results;
    }
}
