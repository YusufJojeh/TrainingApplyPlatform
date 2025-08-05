<?php
// app/controllers/AuthController.php - Unified authentication controller

require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Company.php';

class AuthController {
    
    public function __construct() {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Generate CSRF token
     */
    private function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate CSRF token
     */
    private function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Unified login method
     */
    public function login() {
        $error = '';
        $csrf_token = $this->generateCSRFToken();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!isset($_POST['csrf_token']) || !$this->validateCSRFToken($_POST['csrf_token'])) {
                $error = 'Invalid request. Please try again.';
            } else {
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';
                $role = $_POST['role'] ?? '';
                
                // Validate inputs
                if (empty($username) || empty($password) || empty($role)) {
                    $error = 'All fields are required.';
                } elseif (!in_array($role, ['admin', 'student', 'company'])) {
                    $error = 'Invalid role selected.';
                } else {
                    // Attempt login based on role
                    $user = $this->authenticateUser($username, $password, $role);
                    
                    if ($user) {
                        // Set session data based on role
                        $this->setUserSession($user, $role);
                        
                        // Redirect to appropriate dashboard
                        $this->redirectToDashboard($role);
                        exit;
                    } else {
                        $error = 'Invalid username or password.';
                    }
                }
            }
        }
        
        // Include the unified login view
        require __DIR__ . '/../views/auth/login.php';
    }
    
    /**
     * Authenticate user based on role
     */
    private function authenticateUser($username, $password, $role) {
        switch ($role) {
            case 'admin':
                $model = new Admin($GLOBALS['pdo']);
                break;
            case 'student':
                $model = new Student($GLOBALS['pdo']);
                break;
            case 'company':
                $model = new Company($GLOBALS['pdo']);
                break;
            default:
                return false;
        }
        
        return $model->login($username, $password);
    }
    
    /**
     * Set user session data
     */
    private function setUserSession($user, $role) {
        // Clear any existing sessions
        session_unset();
        
        // Set role-specific session data
        switch ($role) {
            case 'admin':
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['user_role'] = 'admin';
                break;
            case 'student':
                $_SESSION['student_id'] = $user['id'];
                $_SESSION['student_username'] = $user['username'];
                $_SESSION['user_role'] = 'student';
                break;
            case 'company':
                $_SESSION['company_id'] = $user['id'];
                $_SESSION['company_username'] = $user['username'];
                $_SESSION['user_role'] = 'company';
                break;
        }
        
        // Set common session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['login_time'] = time();
        
        // Regenerate session ID for security
        session_regenerate_id(true);
    }
    
    /**
     * Redirect to appropriate dashboard
     */
    private function redirectToDashboard($role) {
        switch ($role) {
            case 'admin':
                header('Location: ?controller=admin&action=dashboard');
                break;
            case 'student':
                header('Location: ?controller=student&action=dashboard');
                break;
            case 'company':
                header('Location: ?controller=company&action=dashboard');
                break;
            default:
                header('Location: ?controller=home');
        }
    }
    
    /**
     * Logout method
     */
    public function logout() {
        // Clear all session data
        session_unset();
        session_destroy();
        
        // Redirect to home page
        header('Location: ?controller=home');
        exit;
    }
    
    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
    }
    
    /**
     * Get current user role
     */
    public static function getUserRole() {
        return $_SESSION['user_role'] ?? null;
    }
    
    /**
     * Require login for protected pages
     */
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ?controller=auth&action=login');
            exit;
        }
    }
    
    /**
     * Require specific role
     */
    public static function requireRole($role) {
        self::requireLogin();
        
        if (self::getUserRole() !== $role) {
            header('Location: ?controller=home');
            exit;
        }
    }
} 