<?php
// app/models/Application.php - Application model

class Application {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Submit a new application
    public function submit($student_id, $company_id) {
        $sql = "INSERT INTO applications (student_id, company_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$student_id, $company_id]);
    }
    
    // Update application status and comment
    public function updateStatus($app_id, $status, $comment = null) {
        $sql = "UPDATE applications SET status=?, comment=?, updated_at=NOW() WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $comment, $app_id]);
    }
    
    // Get applications for a student
    public function getByStudent($student_id) {
        $sql = "SELECT a.*, c.name AS company_name FROM applications a JOIN companies c ON a.company_id = c.id WHERE a.student_id = ? ORDER BY a.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll();
    }
    
    // Get applications for a company
    public function getByCompany($company_id) {
        $sql = "SELECT a.*, s.name AS student_name, s.major FROM applications a JOIN students s ON a.student_id = s.id WHERE a.company_id = ? ORDER BY a.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$company_id]);
        return $stmt->fetchAll();
    }
    
    // Get all applications (admin)
    public function getAll() {
        $sql = "SELECT a.*, s.name AS student_name, c.name AS company_name FROM applications a JOIN students s ON a.student_id = s.id JOIN companies c ON a.company_id = c.id ORDER BY a.created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    
    // Get application by ID
    public function getById($id) {
        $sql = "SELECT a.*, s.name AS student_name, s.major, s.email AS student_email, c.name AS company_name, c.email AS company_email FROM applications a JOIN students s ON a.student_id = s.id JOIN companies c ON a.company_id = c.id WHERE a.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // Delete application
    public function delete($id) {
        $sql = "DELETE FROM applications WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Get application statistics
    public function getStats() {
        $stats = [];
        
        // Total applications
        $sql = "SELECT COUNT(*) FROM applications";
        $stats['total'] = $this->pdo->query($sql)->fetchColumn();
        
        // Pending applications
        $sql = "SELECT COUNT(*) FROM applications WHERE status = 'pending'";
        $stats['pending'] = $this->pdo->query($sql)->fetchColumn();
        
        // Accepted applications
        $sql = "SELECT COUNT(*) FROM applications WHERE status = 'accepted'";
        $stats['accepted'] = $this->pdo->query($sql)->fetchColumn();
        
        // Rejected applications
        $sql = "SELECT COUNT(*) FROM applications WHERE status = 'rejected'";
        $stats['rejected'] = $this->pdo->query($sql)->fetchColumn();
        
        return $stats;
    }
    
    // Check if student already applied to company
    public function hasApplied($student_id, $company_id) {
        $sql = "SELECT COUNT(*) FROM applications WHERE student_id = ? AND company_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id, $company_id]);
        return $stmt->fetchColumn() > 0;
    }
} 