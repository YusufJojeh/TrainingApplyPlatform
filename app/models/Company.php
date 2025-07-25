<?php
// app/models/Company.php - Company model

class Company {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    // Register a new company
    public function register($data) {
        $sql = "INSERT INTO companies (name, email, username, password, field, city, description) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        // Store password as plain text
        return $stmt->execute([
            $data['name'], $data['email'], $data['username'], $data['password'], $data['field'], $data['city'], $data['description']
        ]);
    }
    // Login company
    public function login($username, $password) {
        $sql = "SELECT * FROM companies WHERE username = ? OR email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        if ($user && $password === $user['password']) {
            return $user;
        }
        return false;
    }
    // Get company profile by ID
    public function getProfile($id) {
        $sql = "SELECT * FROM companies WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    // Update company profile
    public function updateProfile($id, $data) {
        $sql = "UPDATE companies SET name=?, email=?, field=?, city=?, description=?, website=?";
        $params = [$data['name'], $data['email'], $data['field'], $data['city'], $data['description'], $data['website']];
        
        // Add logo if provided
        if (isset($data['logo'])) {
            $sql .= ", logo=?";
            $params[] = $data['logo'];
        }
        
        $sql .= " WHERE id=?";
        $params[] = $id;
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    // Update company password
    public function updatePassword($id, $newPassword) {
        $sql = "UPDATE companies SET password = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$newPassword, $id]);
    }
    
    // Get all companies
    public function getAll() {
        $sql = "SELECT * FROM companies ORDER BY name ASC";
        return $this->pdo->query($sql)->fetchAll();
    }
    
    // Get company by username
    public function getByUsername($username) {
        $sql = "SELECT * FROM companies WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    
    // Get company by email
    public function getByEmail($email) {
        $sql = "SELECT * FROM companies WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    // Check if username exists
    public function usernameExists($username, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM companies WHERE username = ?";
        $params = [$username];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    
    // Check if email exists
    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM companies WHERE email = ?";
        $params = [$email];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    
    // Delete company
    public function delete($id) {
        $sql = "DELETE FROM companies WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
} 