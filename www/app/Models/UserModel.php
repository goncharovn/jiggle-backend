<?php

namespace jiggle\app\Models;

use jiggle\database\Db;

class UserModel
{
    private ?int $id;
    private string $name;
    private ?string $email;
    private string $password;
    private string $hash;
    private string $resetKey;
    private bool $twoFactorAuthEnabled;
    private string $twoFactorAuthCode;
    private string $newEmail;
    private string $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getResetKey(): string
    {
        return $this->resetKey;
    }

    public function isTwoFactorAuthEnabled(): bool
    {
        return $this->twoFactorAuthEnabled;
    }

    public function getTwoFactorAuthCode(): string
    {
        return $this->twoFactorAuthCode;
    }

    public function getNewEmail(): string
    {
        return $this->newEmail;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public static function getUserById($id): self
    {
        $queryResult = Db::fetchAll(
            "SELECT 
                u.*
            FROM 
                users u 
            WHERE 
                id = :id",
            [
                'id' => $id,
            ]
        )[0];

        return self::createUser($queryResult);
    }

    public static function getUserByEmail($email): self
    {
        $queryResult = Db::fetchAll(
            "SELECT 
                u.* 
            FROM 
                users u
            WHERE 
                email = :email",
            [
                'email' => $email,
            ]
        )[0];

        return self::createUser($queryResult);
    }

    public static function getUserByHash($hash): self
    {
        $queryResult = Db::fetchAll(
            "SELECT 
                u.*
            FROM 
                users u
            WHERE 
                hash = :hash",
            [
                'hash' => $hash,
            ]
        )[0];

        return self::createUser($queryResult);
    }

    public static function getUserByResetKey($resetKey): self
    {
        $queryResult = Db::fetchAll(
            "SELECT 
                u.*
            FROM 
                users u
            WHERE 
                reset_key = :reset_key",
            [
                'reset_key' => $resetKey,
            ]
        )[0];

        return self::createUser($queryResult);
    }

    public static function addUser($email, $password, $hash): void
    {
        Db::fetchAll(
            "INSERT INTO 
                users (email, password, hash) 
            VALUES 
                (:email, :password, :hash)",
            [
                'email' => $email,
                'password' => $password,
                'hash' => $hash,
            ]
        );
    }

    public static function isUserRegistered(int $id): bool
    {
        return (
            Db::fetchColumn(
                "SELECT 
                EXISTS(
                    SELECT 
                        * 
                    FROM 
                        users 
                    WHERE 
                        id = :id)",
                [
                    'id' => $id,
                ]
            ) !== 0
        );
    }

    public function updateResetKey($resetKey): void
    {
        Db::executeQuery(
            "UPDATE 
                users 
            SET 
                reset_key = :reset_key 
            WHERE 
                email = :email",
            [
                'reset_key' => $resetKey,
                'email' => $this->email,
            ]
        );
    }

    public function updatePassword($password): void
    {
        Db::executeQuery(
            "UPDATE 
                users 
            SET 
                password = :password 
            WHERE 
                reset_key = :reset_key",
            [
                'password' => $password,
                'reset_key' => $this->resetKey,
            ]
        );
    }

    public function deleteResetKey(): void
    {
        Db::executeQuery(
            "UPDATE 
                users 
            SET 
                reset_key = NULL 
            WHERE 
                reset_key = :reset_key",
            [
                'reset_key' => $this->resetKey,
            ]
        );
    }

    public function enableMultifactorAuth(): void
    {
        Db::executeQuery(
            "UPDATE 
                users 
            SET 
                2fa_enabled = true
            WHERE 
                email = :email",
            [
                'email' => $this->email,
            ]
        );
    }

    public function disableMultifactorAuth(): void
    {
        Db::executeQuery(
            "UPDATE 
                users 
            SET 
                2fa_enabled = false 
            WHERE 
                email = :email",
            [
                'email' => $this->email,
            ]
        );
    }

    public function setMultiFactorAuthCode($code): void
    {
        Db::executeQuery(
            "UPDATE 
                users 
            SET 
                2fa_code = :code
            WHERE 
                email = :email",
            [
                'code' => $code,
                'email' => $this->email,
            ]
        );
    }

    public function getMultiFactorAuthCode()
    {
        return (Db::fetchAll(
            "SELECT 
                2fa_code 
            FROM 
                users
            WHERE 
                email = :email",
            [
                'email' => $this->email,
            ]
        )[0]['2fa_code']);
    }

    public function updateName($name): void
    {
        Db::executeQuery(
            "UPDATE 
                users
            SET 
                name = :user_name
            WHERE 
                id = :user_id",
            [
                'user_name' => $name,
                'user_id' => $this->id,
            ]
        );
    }

    public function updateEmail($userEmail): void
    {
        Db::executeQuery(
            "UPDATE 
                users
            SET 
                email = :user_email
            WHERE 
                id = :user_id",
            [
                'user_email' => $userEmail,
                'user_id' => $this->id,
            ]
        );
    }

    public function updateNewEmail($userNewEmail): void
    {
        Db::executeQuery(
            "UPDATE 
                users
            SET 
                new_email = :user_new_email
            WHERE 
                id = :user_id",
            [
                'user_new_email' => $userNewEmail,
                'user_id' => $this->id,
            ]
        );
    }

    public function updateHash($userHash): void
    {
        Db::executeQuery(
            "UPDATE 
                users
            SET 
                hash = :user_hash
            WHERE 
                id = :user_id",
            [
                'user_hash' => $userHash,
                'user_id' => $this->id,
            ]
        );
    }

    private static function createUser(mixed $queryResult): self
    {
        $user = new self();
        $user->id = $queryResult['id'] ?? null;
        $user->name = $queryResult['name'] ?? '';
        $user->email = $queryResult['email'] ?? null;
        $user->password = $queryResult['password'] ?? '';
        $user->hash = $queryResult['hash'] ?? '';
        $user->resetKey = $queryResult['reset_key'] ?? '';
        $user->twoFactorAuthEnabled = $queryResult['2fa_enabled'] ?? false;
        $user->twoFactorAuthCode = $queryResult['2fa_code'] ?? '';
        $user->newEmail = $queryResult['new_email'] ?? '';
        $user->role = $queryResult['role'] ?? '';

        return $user;
    }
}