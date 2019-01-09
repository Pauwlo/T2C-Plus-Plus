<?php

class FavoriteGateway
{
    private $db;
    private $prefix;

    function __construct()
    {
        global $dsn, $user, $password, $tableNamePrefix;
        $this->db = new Connection($dsn, $user, $password);
        $this->prefix = $tableNamePrefix;
    }

    public function getFavoritesByID(int $userID) : array
    {
        $query = 'SELECT name, stop, direction FROM ' . $this->prefix . 'favorites WHERE user_id = :userID ORDER BY id';
        $this->db->executeQuery($query, [
            ':userID' => [$userID, PDO::PARAM_INT]
        ]);
        $results = $this->db->getResults();

        $array = [];

        foreach ($results as $favorite)
        {
            $array[] = new Favorite($favorite['name'], $favorite['stop'], $favorite['direction']);
        }

        return $array;
    }

    public function updateByID(int $id)
    {
        $query = 'UPDATE ' . $this->prefix . 'favorites SET updated_at = NOW(), last_ip = :ip WHERE id : id';
        $this->db->executeQuery($query, [
            ':id' => [$id, PDO::PARAM_INT]
        ]);
    }

    public function addFavoriteByID(int $userID, Favorite $favorite)
    {
        $query = 'INSERT INTO ' . $this->prefix . 'favorites (user_id, name, stop, direction, created_by) VALUES (:userID, :name, :stop, :direction, :ip)';
        $this->db->executeQuery($query, [
            ':userID' => [$userID, PDO::PARAM_INT],
            ':name' => [$favorite->getName(), PDO::PARAM_STR],
            ':stop' => [$favorite->getStop(), PDO::PARAM_STR],
            ':direction' => [$favorite->getDirection(), PDO::PARAM_STR],
            ':ip' => [$_SERVER['REMOTE_ADDR'], PDO::PARAM_STR]
        ]);
    }

    public function removeFavoriteByID(int $userID, Favorite $favorite)
    {
        $query = 'DELETE FROM ' . $this->prefix . 'favorites WHERE user_id = :userID AND name = :name';
        $this->db->executeQuery($query, [
            ':userID' => [$userID, PDO::PARAM_INT],
            ':name' => [$favorite->getName(), PDO::PARAM_STR]
        ]);
    }
}
