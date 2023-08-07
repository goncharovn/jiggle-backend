<?php

namespace app\Models;

use app\Model;

class AccountModel extends Model
{
    public function addUser($email, $password, $hash): void
    {
        $this->db->fetchAll("
            INSERT INTO users (email, password, hash, email_confirmed) 
            VALUES ('$email', '$password', '$hash', 1)
        ");
    }

    public function isUserRegistered($email): bool
    {
        return $this->db->fetchColumn("
            SELECT id 
            FROM users 
            WHERE email = '$email'
        ") !== false;
    }

    public function getUserByEmail($email)
    {
        return $this->db->fetchAll("
            SELECT id, name, password 
            FROM users 
            WHERE email = '$email'
        ")[0];
    }

    public function getUserByHash($hash)
    {
        return ($this->db->fetchAll("
            SELECT id, email_confirmed
            FROM users
            WHERE hash = '$hash'
        ")[0]);
    }
}