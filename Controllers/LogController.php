<?php

require_once 'Models/Log.php';

class LogController
{
    private $m;
    private $g;

    function __construct()
    {
        $this->g = new LogGateway;
    }

    public function log($userID, $action, $type = 'info')
    {
        new Log($userID, $type, $action);
    }
}
