<?php
// app/controllers/CompanyController.php - Company controller

require_once __DIR__ . '/../models/Company.php';
require_once __DIR__ . '/../models/Application.php';
require_once __DIR__ . '/../models/Message.php';

class CompanyController {
    private function requireLogin() {
        if (!isset($_SESSION['company_id'])) {
            header('Location: ?controller=company&action=login');
            exit;
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $companyModel = new Company($GLOBALS['pdo']);
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'username' => $_POST['username'] ?? '',
                'password' => $_POST['password'] ?? '',
                'field' => $_POST['field'] ?? '',
                'city' => $_POST['city'] ?? '',
                'description' => $_POST['description'] ?? ''
            ];
            if ($companyModel->register($data)) {
                header('Location: ?controller=company&action=login');
                exit;
            } else {
                $error = 'Registration failed. Please try again.';
                require __DIR__ . '/../views/company/register.php';
            }
        } else {
            require __DIR__ . '/../views/company/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $companyModel = new Company($GLOBALS['pdo']);
            $company = $companyModel->login($username, $password);
            if ($company) {
                $_SESSION['company_id'] = $company['id'];
                $_SESSION['company_username'] = $company['username'];
                header('Location: ?controller=company&action=dashboard');
                exit;
            } else {
                $error = 'Invalid username or password.';
                require __DIR__ . '/../views/company/login.php';
            }
        } else {
            require __DIR__ . '/../views/company/login.php';
        }
    }

    public function dashboard() {
        $this->requireLogin();
        require __DIR__ . '/../views/company/dashboard.php';
    }

    public function profile() {
        $this->requireLogin();
        
        $companyModel = new Company($GLOBALS['pdo']);
        $company = $companyModel->getProfile($_SESSION['company_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'field' => $_POST['field'] ?? '',
                'city' => $_POST['city'] ?? '',
                'description' => $_POST['description'] ?? '',
                'website' => $_POST['website'] ?? ''
            ];
            
            // Handle logo upload
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileExtension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $fileName = 'logo_' . $_SESSION['company_id'] . '_' . time() . '.' . $fileExtension;
                    $uploadPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadPath)) {
                        $data['logo'] = $uploadPath;
                    }
                }
            }
            
            if ($companyModel->updateProfile($_SESSION['company_id'], $data)) {
                $success = 'Profile updated successfully!';
                $company = $companyModel->getProfile($_SESSION['company_id']); // Refresh data
            } else {
                $error = 'Failed to update profile. Please try again.';
            }
        }
        
        require __DIR__ . '/../views/company/profile.php';
    }

    public function settings() {
        $this->requireLogin();
        
        $companyModel = new Company($GLOBALS['pdo']);
        $company = $companyModel->getProfile($_SESSION['company_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Verify current password
            if ($currentPassword !== $company['password']) {
                $error = 'Current password is incorrect.';
            } elseif (strlen($newPassword) < 6) {
                $error = 'New password must be at least 6 characters long.';
            } elseif ($newPassword !== $confirmPassword) {
                $error = 'New passwords do not match.';
            } else {
                if ($companyModel->updatePassword($_SESSION['company_id'], $newPassword)) {
                    $success = 'Password changed successfully!';
                } else {
                    $error = 'Failed to change password. Please try again.';
                }
            }
        }
        
        require __DIR__ . '/../views/company/settings.php';
    }

    public function inbox() {
        $this->requireLogin();
        
        $messageModel = new Message($GLOBALS['pdo']);
        $messages = $messageModel->getByUser($_SESSION['company_id'], 'company');
        
        // Mark messages as read
        if (isset($_GET['mark_read']) && is_numeric($_GET['mark_read'])) {
            $messageModel->markAsRead($_GET['mark_read']);
        }
        
        require __DIR__ . '/../views/company/inbox.php';
    }

    public function viewMessage() {
        $this->requireLogin();
        
        $messageId = $_GET['id'] ?? 0;
        $messageModel = new Message($GLOBALS['pdo']);
        $message = $messageModel->getById($messageId);
        
        if (!$message || $message['receiver_id'] != $_SESSION['company_id'] || $message['receiver_type'] !== 'company') {
            header('Location: ?controller=company&action=inbox');
            exit;
        }
        // Mark as read
        $messageModel->markAsRead($messageId);
        require __DIR__ . '/../views/company/view_message.php';
    }

    public function reply() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $messageId = $_POST['message_id'] ?? 0;
            $replyContent = $_POST['reply_content'] ?? '';
            
            if (empty($replyContent)) {
                $error = 'Reply content cannot be empty.';
            } else {
                $messageModel = new Message($GLOBALS['pdo']);
                $originalMessage = $messageModel->getById($messageId);
                
                if ($originalMessage && $originalMessage['recipient_id'] == $_SESSION['company_id'] && $originalMessage['recipient_type'] === 'company') {
                    $replyData = [
                        'sender_id' => $_SESSION['company_id'],
                        'sender_type' => 'company',
                        'recipient_id' => $originalMessage['sender_id'],
                        'recipient_type' => 'student',
                        'subject' => 'Re: ' . $originalMessage['subject'],
                        'content' => $replyContent,
                        'application_id' => $originalMessage['application_id'] ?? null
                    ];
                    
                    if ($messageModel->create($replyData)) {
                        $success = 'Reply sent successfully!';
                    } else {
                        $error = 'Failed to send reply. Please try again.';
                    }
                } else {
                    $error = 'Invalid message.';
                }
            }
        }
        
        header('Location: ?controller=company&action=inbox');
        exit;
    }

    public function logout() {
        session_destroy();
        header('Location: ?controller=home');
        exit;
    }
    
    public function composeMessage() {
        $this->requireLogin();
        require __DIR__ . '/../views/company/compose_message.php';
    }
} 