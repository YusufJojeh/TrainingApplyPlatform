<?php
// app/controllers/ApplicationController.php - Application controller

require_once __DIR__ . '/../models/Application.php';
require_once __DIR__ . '/../models/Company.php';

class ApplicationController {
    
    public function list() {
        $applicationModel = new Application($GLOBALS['pdo']);
        $applications = $applicationModel->getAll();
        require __DIR__ . '/../views/applications/list.php';
    }
    
    public function detail() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?controller=application&action=list');
            exit;
        }
        $pdo = $GLOBALS['pdo'];
        $application = $pdo->query("SELECT a.*, s.name AS student_name, c.name AS company_name FROM applications a JOIN students s ON a.student_id = s.id JOIN companies c ON a.company_id = c.id WHERE a.id = " . intval($id))->fetch();
        if (!$application) {
            header('Location: ?controller=application&action=list');
            exit;
        }
        require __DIR__ . '/../views/applications/detail.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_SESSION['student_id'] ?? null;
            $company_id = $_POST['company_id'] ?? null;
            $subject = $_POST['subject'] ?? '';
            $cover_letter = $_POST['cover_letter'] ?? '';
            $cv_path = null;
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../../public/uploads/cv/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                $filename = uniqid('cv_') . '_' . basename($_FILES['cv']['name']);
                $target = $upload_dir . $filename;
                if (move_uploaded_file($_FILES['cv']['tmp_name'], $target)) {
                    $cv_path = 'uploads/cv/' . $filename;
                }
            }
            if ($student_id && $company_id) {
                $applicationModel = new Application($GLOBALS['pdo']);
                $applicationModel->submit($student_id, $company_id);
                $app_id = $GLOBALS['pdo']->lastInsertId();
                // Send message to company with cover letter and CV link
                $_SESSION['compose_subject'] = $subject;
                $_SESSION['compose_content'] = $cover_letter . ($cv_path ? "\n\nCV: " . $cv_path : '');
                header('Location: ?controller=student&action=composeMessage&company_id=' . $company_id . '&application_id=' . $app_id);
                exit;
            }
        }
        
        // Get companies for dropdown
        $companyModel = new Company($GLOBALS['pdo']);
        $companies = $companyModel->getAll();
        require __DIR__ . '/../views/applications/create.php';
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $application_id = $_POST['application_id'] ?? null;
            $status = $_POST['status'] ?? null;
            $comment = $_POST['comment'] ?? '';
            
            if ($application_id && $status) {
                $applicationModel = new Application($GLOBALS['pdo']);
                $applicationModel->updateStatus($application_id, $status, $comment);
                header('Location: ?controller=application&action=list&msg=updated');
                exit;
            }
        }
        
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?controller=application&action=list');
            exit;
        }
        
        $applicationModel = new Application($GLOBALS['pdo']);
        $application = $GLOBALS['pdo']->query("SELECT * FROM applications WHERE id = " . intval($id))->fetch();
        require __DIR__ . '/../views/applications/update.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $applicationModel = new Application($GLOBALS['pdo']);
            $applicationModel->delete($id);
        }
        header('Location: ?controller=application&action=list&msg=deleted');
        exit;
    }
    
    public function approve() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $applicationModel = new Application($GLOBALS['pdo']);
            $applicationModel->updateStatus($id, 'accepted', 'Application approved');
        }
        header('Location: ?controller=application&action=list&msg=approved');
        exit;
    }
    
    public function reject() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $applicationModel = new Application($GLOBALS['pdo']);
            $applicationModel->updateStatus($id, 'rejected', 'Application rejected');
        }
        header('Location: ?controller=application&action=list&msg=rejected');
        exit;
    }
} 