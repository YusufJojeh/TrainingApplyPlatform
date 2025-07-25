<?php
// app/models/Admin.php - Admin model

class Admin {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    // Login admin
    public function login($username, $password) {
        $sql = "SELECT * FROM admins WHERE username = ? OR email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        if ($user && $password === $user['password']) {
            return $user;
        }
        return false;
    }
    // Get all students
    public function getAllStudents() {
        $sql = "SELECT * FROM students";
        return $this->pdo->query($sql)->fetchAll();
    }
    // Get all companies
    public function getAllCompanies() {
        $sql = "SELECT * FROM companies";
        return $this->pdo->query($sql)->fetchAll();
    }
    // Get all applications
    public function getAllApplications() {
        $sql = "SELECT a.*, s.name AS student_name, c.name AS company_name FROM applications a JOIN students s ON a.student_id = s.id JOIN companies c ON a.company_id = c.id";
        return $this->pdo->query($sql)->fetchAll();
    }
    // Create a new student
    public function createStudent($data) {
        $sql = "INSERT INTO students (name, email, username, password, major, city, cv, linkedin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['username'],
            $data['password'],
            $data['major'],
            $data['city'],
            $data['cv'] ?? null,
            $data['linkedin'] ?? null
        ]);
    }
    // Update a student
    public function updateStudent($id, $data) {
        $sql = "UPDATE students SET name = ?, email = ?, username = ?, password = ?, major = ?, city = ?, cv = ?, linkedin = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['username'],
            $data['password'],
            $data['major'],
            $data['city'],
            $data['cv'] ?? null,
            $data['linkedin'] ?? null,
            $id
        ]);
    }
    // Delete a student
    public function deleteStudent($id) {
        $sql = "DELETE FROM students WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    // Create a new company
    public function createCompany($data) {
        $sql = "INSERT INTO companies (name, email, username, password, field, city, description, website, logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['username'],
            $data['password'],
            $data['field'],
            $data['city'],
            $data['description'] ?? null,
            $data['website'] ?? null,
            $data['logo'] ?? null
        ]);
    }
    // Update a company
    public function updateCompany($id, $data) {
        $sql = "UPDATE companies SET name = ?, email = ?, username = ?, password = ?, field = ?, city = ?, description = ?, website = ?, logo = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['username'],
            $data['password'],
            $data['field'],
            $data['city'],
            $data['description'] ?? null,
            $data['website'] ?? null,
            $data['logo'] ?? null,
            $id
        ]);
    }
    // Delete a company
    public function deleteCompany($id) {
        $sql = "DELETE FROM companies WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    // Create a new application
    public function createApplication($data) {
        $sql = "INSERT INTO applications (student_id, company_id, status, comment, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['student_id'],
            $data['company_id'],
            $data['status'],
            $data['comment']
        ]);
    }
    // Update an application
    public function updateApplication($id, $data) {
        $sql = "UPDATE applications SET status = ?, comment = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['status'],
            $data['comment'],
            $id
        ]);
    }
    // Delete an application
    public function deleteApplication($id) {
        $sql = "DELETE FROM applications WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
} 