<?php

namespace app\Models;

use app\Model;

class UserModel extends Model
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

    public function getUserById($id)
    {
        return $this->db->fetchAll("
            SELECT name, email 
            FROM users 
            WHERE id = '$id'
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

    public function getUserByResetKey($resetKey)
    {
        return ($this->db->fetchAll("
            SELECT id
            FROM users
            WHERE reset_key = '$resetKey'
        ")[0]);
    }

    public function addResetKey($email, $resetKey): void
    {
        $this->db->executeQuery("
            UPDATE users 
            SET reset_key = '$resetKey' 
            WHERE email = '$email'
        ");
    }

    public function changePassword($resetKey, $password): void
    {
        $this->db->executeQuery("
            UPDATE users 
            SET password = '$password' 
            WHERE reset_key = '$resetKey'
        ");
    }
    public function deleteResetKey($resetKey): void
    {
        $this->db->executeQuery("
            UPDATE users 
            SET reset_key = NULL 
            WHERE reset_key = '$resetKey'
        ");
    }
}