<?php

class User {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    // 1. Registrace (Zůstává stejné, jen pro jistotu)
    public function register(string $username, string $email, string $password, ?string $firstName = null, ?string $lastName = null, ?string $nickname = null): bool {
        if ($this->findByEmail($email)) {
            return false; 
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password, first_name, last_name, nickname, role) 
                VALUES (:username, :email, :password, :first_name, :last_name, :nickname, 'user')";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':nickname' => $nickname
        ]);
    }

    // 2. Nalezení podle emailu
    public function findByEmail(string $email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // 3. Nalezení podle ID
    public function findById(int $id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 4. Seznam VŠECH uživatelů - OPRAVENO: Přidány sloupce pro jméno a příjmení
    public function getAll() {
        // Přidali jsme first_name a last_name, aby se v tabulce adminovi nezobrazovaly chyby
        $sql = "SELECT id, username, email, first_name, last_name, role, created_at FROM users ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Změna ROLE (Nové: Abys mohl v adminu měnit role)
    public function updateRole(int $id, string $role): bool {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':role' => $role
        ]);
    }

    // 6. Aktualizace profilu
    public function updateProfile(int $id, string $username, ?string $firstName, ?string $lastName, ?string $nickname): bool {
        $sql = "UPDATE users 
                SET username = :username, first_name = :first_name, last_name = :last_name, nickname = :nickname 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':username' => $username,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':nickname' => $nickname
        ]);
    }

    // 7. Smazání uživatele
    public function delete(int $id): bool {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}