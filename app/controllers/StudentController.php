<?php
// app/controllers/StudentController.php - Student controller

require_once __DIR__ . '/../models/Student.php';

class StudentController {
    private function requireLogin() {
        if (!isset($_SESSION['student_id'])) {
            header('Location: ?controller=student&action=login');
            exit;
        }
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentModel = new Student($GLOBALS['pdo']);
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'username' => $_POST['username'] ?? '',
                'password' => $_POST['password'] ?? '',
                'major' => $_POST['major'] ?? '',
                'city' => $_POST['city'] ?? ''
            ];
            if ($studentModel->register($data)) {
                header('Location: ?controller=student&action=login');
                exit;
            } else {
                $error = 'Registration failed. Please try again.';
                require __DIR__ . '/../views/student/register.php';
            }
        } else {
            require __DIR__ . '/../views/student/register.php';
        }
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $studentModel = new Student($GLOBALS['pdo']);
            $student = $studentModel->login($username, $password);
            if ($student) {
                $_SESSION['student_id'] = $student['id'];
                $_SESSION['student_username'] = $student['username'];
                header('Location: ?controller=student&action=dashboard');
                exit;
            } else {
                $error = 'Invalid username or password.';
                require __DIR__ . '/../views/student/login.php';
            }
        } else {
            require __DIR__ . '/../views/student/login.php';
        }
    }
    
    public function dashboard() {
        $this->requireLogin();
        require __DIR__ . '/../views/student/dashboard.php';
    }
    
    public function profile() {
        $this->requireLogin();
        
        $studentModel = new Student($GLOBALS['pdo']);
        $student = $studentModel->getProfile($_SESSION['student_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'major' => $_POST['major'] ?? '',
                'city' => $_POST['city'] ?? '',
                'linkedin' => $_POST['linkedin'] ?? ''
            ];
            
            // Handle CV upload
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                $fileName = 'cv_' . $_SESSION['student_id'] . '_' . time() . '.pdf';
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['cv']['tmp_name'], $uploadPath)) {
                    $data['cv'] = $uploadPath;
                }
            }
            
            if ($studentModel->updateProfile($_SESSION['student_id'], $data)) {
                $success = 'Profile updated successfully!';
                $student = $studentModel->getProfile($_SESSION['student_id']); // Refresh data
            } else {
                $error = 'Failed to update profile. Please try again.';
            }
        }
        
        require __DIR__ . '/../views/student/profile.php';
    }
    
    public function settings() {
        $this->requireLogin();
        
        $studentModel = new Student($GLOBALS['pdo']);
        $student = $studentModel->getProfile($_SESSION['student_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if ($currentPassword === $student['password']) {
                if ($newPassword === $confirmPassword && strlen($newPassword) >= 6) {
                    if ($studentModel->updatePassword($_SESSION['student_id'], $newPassword)) {
                        $success = 'Password updated successfully!';
                    } else {
                        $error = 'Failed to update password. Please try again.';
                    }
                } else {
                    $error = 'New passwords do not match or are too short.';
                }
            } else {
                $error = 'Current password is incorrect.';
            }
        }
        
        require __DIR__ . '/../views/student/settings.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location: ?controller=home');
        exit;
    }
    
    public function composeMessage() {
        $this->requireLogin();
        require __DIR__ . '/../views/student/compose_message.php';
    }
} 