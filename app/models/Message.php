<?php
// app/models/Message.php - Message model

class Message {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Send a message
    public function send($sender_id, $sender_type, $receiver_id, $receiver_type, $content, $application_id = null) {
        $sql = "INSERT INTO messages (sender_id, sender_type, receiver_id, receiver_type, content, application_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$sender_id, $sender_type, $receiver_id, $receiver_type, $content, $application_id]);
    }
    
    // Create a message (alias for send)
    public function create($data) {
        $sql = "INSERT INTO messages (sender_id, sender_type, receiver_id, receiver_type, subject, content, application_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['sender_id'],
            $data['sender_type'],
            $data['receiver_id'],
            $data['receiver_type'],
            $data['subject'] ?? '',
            $data['content'],
            $data['application_id'] ?? null
        ]);
    }
    
    // Get messages by user (student or company)
    public function getByUser($user_id, $user_type) {
        $sql = "SELECT m.*, 
                       CASE 
                           WHEN m.sender_type = 'student' THEN s.name 
                           WHEN m.sender_type = 'company' THEN c.name 
                           ELSE 'Unknown' 
                       END as sender_name,
                       CASE 
                           WHEN m.receiver_type = 'student' THEN s2.name 
                           WHEN m.receiver_type = 'company' THEN c2.name 
                           ELSE 'Unknown' 
                       END as receiver_name
                FROM messages m 
                LEFT JOIN students s ON m.sender_type = 'student' AND m.sender_id = s.id
                LEFT JOIN companies c ON m.sender_type = 'company' AND m.sender_id = c.id
                LEFT JOIN students s2 ON m.receiver_type = 'student' AND m.receiver_id = s2.id
                LEFT JOIN companies c2 ON m.receiver_type = 'company' AND m.receiver_id = c2.id
                WHERE (m.sender_id = ? AND m.sender_type = ?) OR (m.receiver_id = ? AND m.receiver_type = ?) 
                ORDER BY m.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $user_type, $user_id, $user_type]);
        return $stmt->fetchAll();
    }
    
    // Get messages by application
    public function getByApplication($application_id) {
        $sql = "SELECT m.*, 
                       CASE 
                           WHEN m.sender_type = 'student' THEN s.name 
                           WHEN m.sender_type = 'company' THEN c.name 
                           ELSE 'Unknown' 
                       END as sender_name
                FROM messages m 
                LEFT JOIN students s ON m.sender_type = 'student' AND m.sender_id = s.id
                LEFT JOIN companies c ON m.sender_type = 'company' AND m.sender_id = c.id
                WHERE m.application_id = ? 
                ORDER BY m.created_at ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$application_id]);
        return $stmt->fetchAll();
    }
    
    // Get received messages only
    public function getReceived($user_id, $user_type) {
        $sql = "SELECT * FROM messages WHERE receiver_id = ? AND receiver_type = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $user_type]);
        return $stmt->fetchAll();
    }
    
    // Get sent messages only
    public function getSent($user_id, $user_type) {
        $sql = "SELECT * FROM messages WHERE sender_id = ? AND sender_type = ? ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $user_type]);
        return $stmt->fetchAll();
    }
    
    // Mark message as read
    public function markAsRead($id) {
        $sql = "UPDATE messages SET is_read = 1 WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Get unread message count
    public function getUnreadCount($user_id, $user_type) {
        $sql = "SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND receiver_type = ? AND is_read = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $user_type]);
        return $stmt->fetchColumn();
    }
    
    // Delete a message
    public function delete($id) {
        $sql = "DELETE FROM messages WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Get message by ID
    public function getById($id) {
        $sql = "SELECT * FROM messages WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
} 