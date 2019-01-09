<?php

class LogGateway
{
    private $db;
    private $prefix;

    function __construct()
    {
        global $dsn, $user, $password, $tableNamePrefix;
        $this->db = new Connection($dsn, $user, $password);
        $this->prefix = $tableNamePrefix;
    }

    public function getLogByID(int $id) : Log
    {
        $query = 'SELECT * FROM ' . $this->prefix . 'logs WHERE id = :id';
        $this->db->executeQuery($query, [
            ':id' => [$id, PDO::PARAM_INT]
        ]);
        $results = $this->db->getResults();

        if (count($results) == 1)
        {
            $id = $results[0]['id'];

            $this->updateByID($id);
            return new User($id);
        }

        throw new Exception("Log not found: $id");
    }

    public function addLog(Log $log)
    {
        $userID = ($log->getUserID() == -1) ? null : $log->getUserID();
        
        $query = 'INSERT INTO ' . $this->prefix . 'logs (user_id, ip, type, action) VALUES (:userID, :ip, :type, :action)';
        $this->db->executeQuery($query, [
            ':userID' => [$userID, PDO::PARAM_INT],
            ':ip' => [$_SERVER['REMOTE_ADDR'], PDO::PARAM_STR],
            ':type' => [$log->getType(), PDO::PARAM_STR],
            ':action' => [$log->getAction(), PDO::PARAM_STR]
        ]);
    }
}
