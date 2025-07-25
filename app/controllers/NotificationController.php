<?php
// app/controllers/NotificationController.php - Notification controller

class NotificationController {
    public function list() {
        require __DIR__ . '/../views/notifications/list.php';
    }
    public function markAsRead() {
        // Handle mark as read logic
    }
    public function delete() {
        // Handle delete logic
    }
} 