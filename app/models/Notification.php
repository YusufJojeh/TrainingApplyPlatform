<?php
// app/models/Notification.php - Notification model

class Notification {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function create($user_id, $user_type, $message) {
        $sql = "INSERT INTO notifications (user_id, user_type, message) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$user_id, $user_type, $message]);
    }
    public function getByUser($user_id, $user_type) {
        $sql = "SELECT * FROM notifications WHERE user_id = ? AND user_type = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $user_type]);
        return $stmt->fetchAll();
    }
    public function markAsRead($id) {
        $sql = "UPDATE notifications SET is_read=1 WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function delete($id) {
        $sql = "DELETE FROM notifications WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
} 