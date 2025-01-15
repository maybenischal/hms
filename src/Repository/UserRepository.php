<?php

namespace App\Repository;

class UserRepository {
    private $db;
    private $table = 'users';

    public function __construct($db) {
        $this->db = $db;
    }

    public function authenticate($email, $password) {
        try {
            error_log("Attempting authentication for email: " . $email);
            
            $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";
            $stmt = $this->db->query($sql, [$email]);
            $user = $stmt->fetch();

            if ($user) {
                error_log("User found, verifying password");
                if (password_verify($password, $user['password'])) {
                    error_log("Password verified successfully");
                    unset($user['password']);
                    return $user;
                }
                error_log("Password verification failed");
            }
            error_log("User not found or authentication failed");
            return false;
        } catch (\Exception $e) {
            error_log("Authentication error: " . $e->getMessage());
            return false;
        }
    }

    public function createUser($data) {
        try {
            // Check if email already exists
            $existingUser = $this->findByEmail($data['email']);
            if ($existingUser) {
                throw new \Exception("Email already exists");
            }

            $sql = "INSERT INTO {$this->table} (user_name, email, password, user_type) 
                    VALUES (?, ?, ?, ?)";
            
            $this->db->query($sql, [
                $data['user_name'],
                $data['email'],
                $data['password'],
                $data['user_type'] ?? 'EXTERNAL'
            ]);

            return $this->db->lastInsertId();
        } catch (\Exception $e) {
            error_log("Error creating user: " . $e->getMessage());
            throw $e;
        }
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";
        $stmt = $this->db->query($sql, [$email]);
        return $stmt->fetch();
    }
} 