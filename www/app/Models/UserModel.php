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
    private bool $multiFactorAuthEnabled;
    private string $multiFactorAuthCode;
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

    public function isMultiFactorAuthEnabled(): bool
    {
        return $this->multiFactorAuthEnabled;
    }

    public function getMultiFactorAuthCode(): string
    {
        return $this->multiFactorAuthCode;
    }

    public function getNewEmail(): string
    {
        return $this->newEmail;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public static function getUserById(int $id): ?self
    {
        $queryResult = Db::fetchAll(
            'SELECT 
                u.*
            FROM 
                users u 
            WHERE 
                id = :id',
            [
                'id' => $id,
            ]
        )[0];

        return $queryResult ? self::createUser($queryResult) : null;
    }

    public static function getUserByEmail(string $email): ?self
    {
        $queryResult = Db::fetchAll(
            'SELECT 
                u.* 
            FROM 
                users u
            WHERE 
                email = :email',
            [
                'email' => $email,
            ]
        )[0];

        return $queryResult ? self::createUser($queryResult) : null;
    }

    public static function getUserByHash(string $hash): ?self
    {
        $queryResult = Db::fetchAll(
            'SELECT 
                u.*
            FROM 
                users u
            WHERE 
                hash = :hash',
            [
                'hash' => $hash,
            ]
        )[0];

        return $queryResult ? self::createUser($queryResult) : null;
    }

    public static function getUserByResetKey(string $resetKey): ?self
    {
        $queryResult = Db::fetchAll(
            'SELECT 
                u.*
            FROM 
                users u
            WHERE 
                reset_key = :reset_key',
            [
                'reset_key' => $resetKey,
            ]
        )[0];

        return $queryResult ? self::createUser($queryResult) : null;
    }

    public static function addUser(string $email, string $password, string $hash): void
    {
        Db::fetchAll(
            'INSERT INTO 
                users (email, password, hash) 
            VALUES 
                (:email, :password, :hash)',
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
                'SELECT 
                EXISTS(
                    SELECT 
                        * 
                    FROM 
                        users 
                    WHERE 
                        id = :id)',
                [
                    'id' => $id,
                ]
            ) !== 0
        );
    }

    public function updateResetKey(string $resetKey): void
    {
        Db::executeQuery(
            'UPDATE 
                users 
            SET 
                reset_key = :reset_key 
            WHERE 
                email = :email',
            [
                'reset_key' => $resetKey,
                'email' => $this->email,
            ]
        );
    }

    public function updatePassword(string $password): void
    {
        Db::executeQuery(
            'UPDATE 
                users 
            SET 
                password = :password 
            WHERE 
                reset_key = :reset_key',
            [
                'password' => $password,
                'reset_key' => $this->resetKey,
            ]
        );
    }

    public function deleteResetKey(): void
    {
        Db::executeQuery(
            'UPDATE 
                users 
            SET 
                reset_key = NULL 
            WHERE 
                reset_key = :reset_key',
            [
                'reset_key' => $this->resetKey,
            ]
        );
    }

    public function toggleMultiFactorAuth(): void
    {
        $this->multiFactorAuthEnabled = !$this->multiFactorAuthEnabled;

        Db::executeQuery(
            "UPDATE 
                users 
            SET 
                2fa_enabled = :multiFactorAuthEnabled 
            WHERE 
                id = :id",
            [
                'id' => $this->id,
                'multiFactorAuthEnabled' => (int)$this->multiFactorAuthEnabled
            ]
        );
    }

    public function setMultiFactorAuthCode(string $multiFactorAuthCode): void
    {
        Db::executeQuery(
            'UPDATE 
                users 
            SET 
                2fa_code = :multiFactorAuthCode
            WHERE 
                email = :email',
            [
                'multiFactorAuthCode' => $multiFactorAuthCode,
                'email' => $this->email,
            ]
        );
    }

    public function updateName(string $name): void
    {
        Db::executeQuery(
            'UPDATE 
                users
            SET 
                name = :user_name
            WHERE 
                id = :user_id',
            [
                'user_name' => $name,
                'user_id' => $this->id,
            ]
        );
    }

    public function updateEmail(string $userEmail): void
    {
        Db::executeQuery(
            'UPDATE 
                users
            SET 
                email = :user_email
            WHERE 
                id = :user_id',
            [
                'user_email' => $userEmail,
                'user_id' => $this->id,
            ]
        );
    }

    public function updateNewEmail(string $userNewEmail): void
    {
        Db::executeQuery(
            'UPDATE 
                users
            SET 
                new_email = :user_new_email
            WHERE 
                id = :user_id',
            [
                'user_new_email' => $userNewEmail,
                'user_id' => $this->id,
            ]
        );
    }

    public function updateHash(string $userHash): void
    {
        Db::executeQuery(
            'UPDATE 
                users
            SET 
                hash = :user_hash
            WHERE 
                id = :user_id',
            [
                'user_hash' => $userHash,
                'user_id' => $this->id,
            ]
        );
    }

    private static function createUser(array $userRow): self
    {
        $user = new self();
        $user->id = $userRow['id'] ?? null;
        $user->name = $userRow['name'] ?? '';
        $user->email = $userRow['email'] ?? null;
        $user->password = $userRow['password'] ?? '';
        $user->hash = $userRow['hash'] ?? '';
        $user->resetKey = $userRow['reset_key'] ?? '';
        $user->multiFactorAuthEnabled = $userRow['2fa_enabled'] ?? false;
        $user->multiFactorAuthCode = $userRow['2fa_code'] ?? '';
        $user->newEmail = $userRow['new_email'] ?? '';
        $user->role = $userRow['role'] ?? '';

        return $user;
    }
}