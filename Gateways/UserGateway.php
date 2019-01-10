<?php

class UserGateway
{
    private $db;
    private $prefix;

    function __construct()
    {
        global $dsn, $user, $password, $tableNamePrefix;
        $this->db = new Connection($dsn, $user, $password);
        $this->prefix = $tableNamePrefix;
    }

    public function getUserByID(int $id) : User
    {
        $query = 'SELECT * FROM ' . $this->prefix . 'users WHERE id = :id';
        $this->db->executeQuery($query, [
            ':id' => [$id, PDO::PARAM_INT]
        ]);
        $results = $this->db->getResults();
        
        if (count($results) == 1)
        {
            $id = $results[0]['id'];
            $showBtnAdd = boolval($results[0]['show_btn_add']);
            $dayMode = boolval($results[0]['day_mode']);

            $this->updateByID($id);
            return new User($id, $showBtnAdd, $dayMode);
        }

        return new User;
    }

    public function getUserByPassword(string $password) : User
    {
        $query = 'SELECT * FROM ' . $this->prefix . 'users WHERE password = :password';
        $this->db->executeQuery($query, [
            ':password' => [$password, PDO::PARAM_STR]
        ]);
        $results = $this->db->getResults();
        
        if (count($results) == 1)
        {
            $id = $results[0]['id'];
            $showBtnAdd = boolval($results[0]['show_btn_add']);
            $dayMode = boolval($results[0]['day_mode']);

            $this->updateByID($id);
            return new User($id, $showBtnAdd, $dayMode);
        }

        return new User;
    }

    public function updateByID(int $id)
    {
        $query = 'UPDATE ' . $this->prefix . 'users SET updated_at = NOW(), last_ip = :ip WHERE id = :id';
        $this->db->executeQuery($query, [
            ':ip' => [$_SERVER['REMOTE_ADDR'], PDO::PARAM_STR],
            ':id' => [$id, PDO::PARAM_INT]
        ]);
    }

    public function addUser(string $password, string $token, string $expiryDate) : User
    {
        $query = 'INSERT INTO ' . $this->prefix . 'users (password, token, token_expiration_at, created_by, last_ip) VALUES (:password, :token, :expiryDate, :ip, :lastIp)';
        $this->db->executeQuery($query, [
            ':password' => [$password, PDO::PARAM_STR],
            ':token' => [$token, PDO::PARAM_STR],
            ':expiryDate' => [$expiryDate, PDO::PARAM_STR],
            ':ip' => [$_SERVER['REMOTE_ADDR'], PDO::PARAM_STR],
            ':lastIp' => [$_SERVER['REMOTE_ADDR'], PDO::PARAM_STR]
        ]);

        return $this->getUserByPassword($password);
    }

    public function verifyTokenByID(int $id, string $token) : bool
    {
        $query = 'SELECT token, token_expiration_at FROM ' . $this->prefix . 'users WHERE id = :id';
        $this->db->executeQuery($query, [
            ':id' => [$id, PDO::PARAM_INT]
        ]);
        $results = $this->db->getResults();

        $this->updateByID($id);

        $isValid = password_verify($token, $results[0]['token']);
        $hasExpired = (strtotime($results[0]['token_expiration_at']) - time()) < 0;

        if ($isValid && ! $hasExpired) {
            return true;
        }

        return false;
    }

    public function updateTokenByID(int $id, string $token, string $expiryDate)
    {
        $query = 'UPDATE ' . $this->prefix . 'users SET token = :token, token_expiration_at = :expiryDate WHERE id = :id';
        $this->db->executeQuery($query, [
            ':token' => [$token, PDO::PARAM_STR],
            ':expiryDate' => [$expiryDate, PDO::PARAM_STR],
            ':id' => [$id, PDO::PARAM_INT]
        ]);
        
        $this->updateByID($id);
    }

    public function resetTokenByID(int $id)
    {
        $query = 'UPDATE ' . $this->prefix . 'users SET token = :token, token_expiration_at = :expiryDate WHERE id = :id';
        $this->db->executeQuery($query, [
            ':token' => null,
            ':expiryDate' => null,
            ':id' => [$id, PDO::PARAM_INT]
        ]);

        $this->updateByID($id);
    }

    public function updateSettingByID(int $id, string $name, string $value)
    {
        $query = 'UPDATE ' . $this->prefix . 'users SET ' . $name . ' = :value WHERE id = :id';
        $this->db->executeQuery($query, [
            ':value' => [$value, PDO::PARAM_STR],
            ':id' => [$id, PDO::PARAM_INT]
        ]);
        
        $this->updateByID($id);
    }
}
