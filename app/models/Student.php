<?php
// app/models/Student.php - Student model

class Student {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Register a new student
    public function register($data) {
        $sql = "INSERT INTO students (name, email, username, password, major, city) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        // Store password as plain text
        return $stmt->execute([
            $data['name'], $data['email'], $data['username'], $data['password'], $data['major'], $data['city']
        ]);
    }
    
    // Login student
    public function login($username, $password) {
        $sql = "SELECT * FROM students WHERE username = ? OR email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        if ($user && $password === $user['password']) {
            return $user;
        }
        return false;
    }
    
    // Get student profile by ID
    public function getProfile($id) {
        $sql = "SELECT * FROM students WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // Update student profile
    public function updateProfile($id, $data) {
        $sql = "UPDATE students SET name=?, email=?, major=?, city=?, linkedin=?";
        $params = [$data['name'], $data['email'], $data['major'], $data['city'], $data['linkedin']];
        
        // Add CV if provided
        if (isset($data['cv'])) {
            $sql .= ", cv=?";
            $params[] = $data['cv'];
        }
        
        $sql .= " WHERE id=?";
        $params[] = $id;
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    // Update student password
    public function updatePassword($id, $newPassword) {
        $sql = "UPDATE students SET password=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$newPassword, $id]);
    }
    
    // Get all students (for admin)
    public function getAll() {
        $sql = "SELECT * FROM students ORDER BY created_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }
    
    // Delete student
    public function delete($id) {
        $sql = "DELETE FROM students WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
} 