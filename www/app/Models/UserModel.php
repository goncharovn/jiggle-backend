<?php

namespace app\Models;

use database\Db;

class UserModel
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $hash;
    private string $resetKey;
    private bool $twoFactorAuthEnabled;
    private string $twoFactorAuthCode;
    private string $newEmail;

    public function addUser($email, $password, $hash): void
    {
        $user = Db::fetchAll(
            "INSERT INTO users (email, password, hash) 
            VALUES (:email, :password, :hash)",
            [
                'email' => $email,
                'password' => $password,
                'hash' => $hash,
            ]
        );
    }

    public function isUserRegistered($email): bool
    {
        return (
            Db::fetchColumn(
                "SELECT id 
            FROM users 
            WHERE email = :email",
                [
                    'email' => $email,
                ]
            ) !== false
        );
    }

    public function getUserByEmail($email)
    {
        return (
        Db::fetchAll(
            "SELECT users.* 
            FROM users 
            WHERE email = :email",
            [
                'email' => $email,
            ]
        )[0]
        );
    }

    public function getUserById($id)
    {
        return Db::fetchAll(
            "SELECT name, email, 2fa_enabled
            FROM users 
            WHERE id = :id",
            [
                'id' => $id,
            ]
        )[0];
    }

    public function getUserByHash($hash)
    {
        return (
        Db::fetchAll(
            "SELECT id, new_email
            FROM users
            WHERE hash = :hash",
            [
                'hash' => $hash,
            ]
        )[0]
        );
    }

    public function getUserByResetKey($resetKey)
    {
        return (
        Db::fetchAll(
            "SELECT id
                FROM users
                WHERE reset_key = :reset_key",
            [
                'reset_key' => $resetKey,
            ]
        )[0]
        );
    }

    public function addResetKey($email, $resetKey): void
    {
        Db::executeQuery(
            "UPDATE users 
            SET reset_key = :reset_key 
            WHERE email = :email",
            [
                'reset_key' => $resetKey,
                'email' => $email,
            ]
        );
    }

    public function changePassword($resetKey, $password): void
    {
        Db::executeQuery(
            "UPDATE users 
            SET password = :password 
            WHERE reset_key = :reset_key",
            [
                'password' => $password,
                'reset_key' => $resetKey,
            ]
        );
    }

    public function deleteResetKey($resetKey): void
    {
        Db::executeQuery(
            "UPDATE users 
            SET reset_key = NULL 
            WHERE reset_key = :reset_key",
            [
                'reset_key' => $resetKey,
            ]
        );
    }

    public function disableMultifactorAuth($email): void
    {
        Db::executeQuery(
            "UPDATE users 
            SET 2fa_enabled = false 
            WHERE email = :email",
            [
                'email' => $email,
            ]
        );
    }

    public function enableMultifactorAuth($email): void
    {
        Db::executeQuery(
            "UPDATE users 
            SET 2fa_enabled = true
            WHERE email = :email",
            [
                'email' => $email,
            ]
        );
    }

    public function setMFACode($code, $email): void
    {
        Db::executeQuery(
            "UPDATE users 
            SET 2fa_code = :code
            WHERE email = :email",
            [
                'code' => $code,
                'email' => $email,
            ]
        );
    }

    public function getMFACode($email)
    {
        return (Db::fetchAll(
            "SELECT 2fa_code 
            FROM users
            WHERE email = :email",
            [
                'email' => $email,
            ]
        )[0]['2fa_code']);
    }

    public function updateUserName($userName, $userId): void
    {
        Db::executeQuery(
            "UPDATE users
            SET name = :user_name
            WHERE id = :user_id",
            [
                'user_name' => $userName,
                'user_id' => $userId,
            ]
        );
    }

    public function updateUserEmail($userEmail, $userId): void
    {
        Db::executeQuery(
            "UPDATE users
            SET email = :user_email
            WHERE id = :user_id",
            [
                'user_email' => $userEmail,
                'user_id' => $userId,
            ]
        );
    }

    public function updateUserNewEmail($userNewEmail, $userId): void
    {
        Db::executeQuery(
            "UPDATE users
            SET new_email = :user_new_email
            WHERE id = :user_id",
            [
                'user_new_email' => $userNewEmail,
                'user_id' => $userId,
            ]
        );
    }

    public function updateUserHash($userHash, $userId): void
    {
        Db::executeQuery(
            "UPDATE users
            SET hash = :user_hash
            WHERE id = :user_id",
            [
                'user_hash' => $userHash,
                'user_id' => $userId,
            ]
        );
    }
}