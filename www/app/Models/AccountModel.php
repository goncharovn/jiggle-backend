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
}