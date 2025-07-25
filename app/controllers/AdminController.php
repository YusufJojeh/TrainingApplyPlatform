<?php
// app/controllers/AdminController.php - Admin controller

require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Application.php';

class AdminController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $adminModel = new Admin($GLOBALS['pdo']);
            $admin = $adminModel->login($username, $password);
            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                header('Location: ?controller=admin&action=dashboard');
                exit;
            } else {
                $error = 'Invalid username or password.';
                require __DIR__ . '/../views/admin/login.php';
            }
        } else {
            require __DIR__ . '/../views/admin/login.php';
        }
    }
    private function requireLogin() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }
    }
    public function dashboard() {
        $this->requireLogin();
        require __DIR__ . '/../views/admin/dashboard.php';
    }
    public function students() {
        $this->requireLogin();
        $adminModel = new Admin($GLOBALS['pdo']);
        $students = $adminModel->getAllStudents();
        require __DIR__ . '/../views/admin/users.php';
    }
    public function companies() {
        $this->requireLogin();
        $adminModel = new Admin($GLOBALS['pdo']);
        $companies = $adminModel->getAllCompanies();
        require __DIR__ . '/../views/admin/users.php';
    }
    public function applications() {
        $this->requireLogin();
        $adminModel = new Admin($GLOBALS['pdo']);
        $applications = $adminModel->getAllApplications();
        require __DIR__ . '/../views/admin/applications.php';
    }
    public function logs() {
        $this->requireLogin();
        // Fetch logs from DB
        $admin_logs = $GLOBALS['pdo']->query('SELECT * FROM admin_logs ORDER BY created_at DESC')->fetchAll();
        $activity_logs = $GLOBALS['pdo']->query('SELECT * FROM activity_logs ORDER BY created_at DESC')->fetchAll();
        require __DIR__ . '/../views/admin/logs.php';
    }
    public function logout() {
        session_destroy();
        header('Location: ?controller=admin&action=login');
        exit;
    }
    // View student details
    public function viewStudent() {
        $this->requireLogin();
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ?controller=admin&action=students'); exit; }
        $adminModel = new Admin($GLOBALS['pdo']);
        $student = $GLOBALS['pdo']->query("SELECT * FROM students WHERE id = " . intval($id))->fetch();
        require __DIR__ . '/../views/admin/student_view.php';
    }
    // Create student
    public function createStudent() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = new Admin($GLOBALS['pdo']);
            $adminModel->createStudent($_POST);
            header('Location: ?controller=admin&action=students'); exit;
        }
        require __DIR__ . '/../views/admin/student_form.php';
    }
    // Edit student
    public function editStudent() {
        $this->requireLogin();
        $id = $_GET['id'] ?? null;
        $adminModel = new Admin($GLOBALS['pdo']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel->updateStudent($id, $_POST);
            header('Location: ?controller=admin&action=students'); exit;
        }
        $student = $GLOBALS['pdo']->query("SELECT * FROM students WHERE id = " . intval($id))->fetch();
        require __DIR__ . '/../views/admin/student_form.php';
    }
    // Delete student
    public function deleteStudent() {
        $this->requireLogin();
        $id = $_GET['id'] ?? null;
        $adminModel = new Admin($GLOBALS['pdo']);
        $adminModel->deleteStudent($id);
        header('Location: ?controller=admin&action=students'); exit;
    }
    // View company details
    public function viewCompany() {
        $this->requireLogin();
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ?controller=admin&action=companies'); exit; }
        $adminModel = new Admin($GLOBALS['pdo']);
        $company = $GLOBALS['pdo']->query("SELECT * FROM companies WHERE id = " . intval($id))->fetch();
        require __DIR__ . '/../views/admin/company_view.php';
    }
    // Create company
    public function createCompany() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = new Admin($GLOBALS['pdo']);
            $adminModel->createCompany($_POST);
            header('Location: ?controller=admin&action=companies'); exit;
        }
        require __DIR__ . '/../views/admin/company_form.php';
    }
    // Edit company
    public function editCompany() {
        $this->requireLogin();
        $id = $_GET['id'] ?? null;
        $adminModel = new Admin($GLOBALS['pdo']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel->updateCompany($id, $_POST);
            header('Location: ?controller=admin&action=companies'); exit;
        }
        $company = $GLOBALS['pdo']->query("SELECT * FROM companies WHERE id = " . intval($id))->fetch();
        require __DIR__ . '/../views/admin/company_form.php';
    }
    // Delete company
    public function deleteCompany() {
        $this->requireLogin();
        $id = $_GET['id'] ?? null;
        $adminModel = new Admin($GLOBALS['pdo']);
        $adminModel->deleteCompany($id);
        header('Location: ?controller=admin&action=companies'); exit;
    }
    // View application details
    public function viewApp() {
        $this->requireLogin();
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ?controller=admin&action=applications'); exit; }
        $adminModel = new Admin($GLOBALS['pdo']);
        $app = $GLOBALS['pdo']->query("SELECT a.*, s.name AS student_name, c.name AS company_name FROM applications a JOIN students s ON a.student_id = s.id JOIN companies c ON a.company_id = c.id WHERE a.id = " . intval($id))->fetch();
        require __DIR__ . '/../views/admin/application_view.php';
    }
    // Update application
    public function updateApp() {
        $this->requireLogin();
        $id = $_GET['id'] ?? null;
        $adminModel = new Admin($GLOBALS['pdo']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel->updateApplication($id, $_POST);
            header('Location: ?controller=admin&action=applications'); exit;
        }
        $app = $GLOBALS['pdo']->query("SELECT * FROM applications WHERE id = " . intval($id))->fetch();
        require __DIR__ . '/../views/admin/application_form.php';
    }
    // Delete application
    public function deleteApp() {
        $this->requireLogin();
        $id = $_GET['id'] ?? null;
        $adminModel = new Admin($GLOBALS['pdo']);
        $adminModel->deleteApplication($id);
        header('Location: ?controller=admin&action=applications'); exit;
    }
} 