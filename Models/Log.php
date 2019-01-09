<?php

require_once 'Gateways/LogGateway.php';

class Log
{
    private $g;
    
    private $userID;
    private $type;
    private $action;

    function __construct(int $userID, string $type, string $action)
    {
        $this->g = new LogGateway;
        
        $this->userID = $userID;
        $this->type = $type;
        $this->action = $action;

        $this->save();
    }

    public function getUserID() : int{
        return $this->userID;
    }

    public function getAction() : string {
        return $this->action;
    }

    public function getType() : string {
        return $this->type;
    }

    public function save() {
        $this->g->addLog($this);
    }
}
