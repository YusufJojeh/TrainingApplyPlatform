<?php
// app/controllers/MessageController.php - Message controller

require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/Application.php';

class MessageController {
    
    public function list() {
        require __DIR__ . '/../views/messages/list.php';
    }
    
    public function send() {
        require __DIR__ . '/../views/messages/send.php';
    }
    
    public function inbox() {
        // Company or student inbox
        $user_id = $_SESSION['company_id'] ?? $_SESSION['student_id'] ?? null;
        $user_type = isset($_SESSION['company_id']) ? 'company' : (isset($_SESSION['student_id']) ? 'student' : null);
        if (!$user_id || !$user_type) {
            header('Location: ?controller=student&action=login'); exit;
        }
        $messageModel = new Message($GLOBALS['pdo']);
        $messages = $messageModel->getByUser($user_id, $user_type);
        require __DIR__ . '/../views/messages/inbox.php';
    }
    
    public function sendApplication() {
        // Student sends application as message/email
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_SESSION['student_id'] ?? null;
            if (!$student_id) { header('Location: ?controller=student&action=login'); exit; }
            $company_id = $_POST['company_id'] ?? null;
            $content = $_POST['content'] ?? '';
            $application_id = $_POST['application_id'] ?? null;
            if ($company_id && $content) {
                $messageModel = new Message($GLOBALS['pdo']);
                $messageModel->send($student_id, 'student', $company_id, 'company', $content, $application_id);
                // Optionally send email here
                header('Location: ?controller=student&action=dashboard&msg=sent'); exit;
            }
        }
        // Show form
        require __DIR__ . '/../views/messages/send_application.php';
    }
    
    public function respond() {
        // Company responds to application (approve/reject)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $company_id = $_SESSION['company_id'] ?? null;
            if (!$company_id) { header('Location: ?controller=company&action=login'); exit; }
            $student_id = $_POST['student_id'] ?? null;
            $application_id = $_POST['application_id'] ?? null;
            $status = $_POST['status'] ?? null;
            $comment = $_POST['comment'] ?? '';
            if ($student_id && $application_id && in_array($status, ['accepted','rejected'])) {
                // Update application status
                $appModel = new Application($GLOBALS['pdo']);
                $appModel->updateStatus($application_id, $status, $comment);
                // Send message to student
                $messageModel = new Message($GLOBALS['pdo']);
                $msg = ($status === 'accepted' ? 'Your application has been accepted.' : 'Your application has been rejected.');
                $messageModel->send($company_id, 'company', $student_id, 'student', $msg . ' ' . $comment, $application_id);
                header('Location: ?controller=message&action=inbox&msg=responded'); exit;
            }
        }
        // Show form
        require __DIR__ . '/../views/messages/response.php';
    }
    
    public function delete() {
        $message_id = $_GET['id'] ?? null;
        if ($message_id) {
            $messageModel = new Message($GLOBALS['pdo']);
            $messageModel->delete($message_id);
        }
        header('Location: ?controller=message&action=inbox');
        exit;
    }
    
    public function markAsRead() {
        $message_id = $_GET['id'] ?? null;
        if ($message_id) {
            $messageModel = new Message($GLOBALS['pdo']);
            $messageModel->markAsRead($message_id);
        }
        header('Location: ?controller=message&action=inbox');
        exit;
    }
} 