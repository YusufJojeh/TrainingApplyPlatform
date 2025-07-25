<?php include __DIR__ . '/../layout/header.php'; ?>
<?php
// Check if user is logged in
if (!isset($_SESSION['student_id']) && !isset($_SESSION['company_id']) && !isset($_SESSION['admin_id'])) {
    header('Location: ?controller=home');
    exit;
}

// Get application data
$applicationId = $_GET['id'] ?? 0;
$applicationModel = new Application($GLOBALS['pdo']);
$application = $applicationModel->getById($applicationId);

if (!$application) {
    header('Location: ?controller=home');
    exit;
}

// Get student and company data
$studentModel = new Student($GLOBALS['pdo']);
$companyModel = new Company($GLOBALS['pdo']);
$student = $studentModel->getProfile($application['student_id']);
$company = $companyModel->getProfile($application['company_id']);

// Check permissions
$isStudent = isset($_SESSION['student_id']) && $_SESSION['student_id'] == $application['student_id'];
$isCompany = isset($_SESSION['company_id']) && $_SESSION['company_id'] == $application['company_id'];
$isAdmin = isset($_SESSION['admin_id']);

if (!$isStudent && !$isCompany && !$isAdmin) {
    header('Location: ?controller=home');
    exit;
}

// Get messages related to this application
$messageModel = new Message($GLOBALS['pdo']);
$messages = $messageModel->getByApplication($applicationId);
?>

<div class="container py-5">
    <div class="row">
        <!-- Application Info Card -->
        <div class="col-lg-4 mb-4">
            <div class="glass-card p-4 h-100">
                <div class="text-center mb-4">
                    <div class="application-icon mb-3">
                        <i class="bi bi-file-earmark-text display-1 text-warning"></i>
                    </div>
                    <h3 class="gradient-text-yellow mb-2">Application #<?= $application['id'] ?></h3>
                    <p class="text-white-50 mb-1"><?= htmlspecialchars($student['name']) ?></p>
                    <p class="text-white-50 mb-3">→ <?= htmlspecialchars($company['name']) ?></p>
                    
                    <?php
                    $statusClass = match($application['status']) {
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        default => 'warning'
                    };
                    $statusText = ucfirst($application['status']);
                    ?>
                    <span class="badge bg-<?= $statusClass ?> fs-6 mb-3"><?= $statusText ?></span>
                    
                    <div class="d-grid gap-2">
                        <?php if ($isStudent): ?>
                            <a href="?controller=student&action=dashboard" class="btn btn-glass btn-outline-warning">
                                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                            </a>
                        <?php elseif ($isCompany): ?>
                            <a href="?controller=company&action=dashboard" class="btn btn-glass btn-outline-warning">
                                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                            </a>
                        <?php else: ?>
                            <a href="?controller=admin&action=applications" class="btn btn-glass btn-outline-warning">
                                <i class="bi bi-arrow-left me-2"></i>Back to Applications
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Details -->
        <div class="col-lg-8">
  <div class="glass-card p-4">
                <h2 class="gradient-text-yellow mb-4">
                    <i class="bi bi-file-earmark-text me-2"></i>Application Details
                </h2>

                <!-- Student Information -->
                <div class="mb-4">
                    <h4 class="text-white-50 mb-3">
                        <i class="bi bi-person me-2"></i>Student Information
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Name</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Email</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Major</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($student['major']) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">City</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($student['city']) ?>" readonly>
                        </div>
                    </div>
                    <?php if ($student['linkedin']): ?>
                        <div class="mb-3">
                            <a href="<?= htmlspecialchars($student['linkedin']) ?>" target="_blank" class="btn btn-outline-info">
                                <i class="bi bi-linkedin me-2"></i>View LinkedIn Profile
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Company Information -->
                <div class="mb-4">
                    <h4 class="text-white-50 mb-3">
                        <i class="bi bi-building me-2"></i>Company Information
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Company Name</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($company['name']) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Field</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($company['field']) ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Email</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($company['email']) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">City</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($company['city']) ?>" readonly>
                        </div>
                    </div>
                    <?php if ($company['website']): ?>
                        <div class="mb-3">
                            <a href="<?= htmlspecialchars($company['website']) ?>" target="_blank" class="btn btn-outline-info">
                                <i class="bi bi-globe me-2"></i>Visit Company Website
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Application Status -->
                <div class="mb-4">
                    <h4 class="text-white-50 mb-3">
                        <i class="bi bi-info-circle me-2"></i>Application Status
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Status</label>
                            <input type="text" class="form-control" value="<?= $statusText ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Applied Date</label>
                            <input type="text" class="form-control" value="<?= date('M d, Y H:i', strtotime($application['created_at'])) ?>" readonly>
                        </div>
                    </div>
                    <?php if ($application['comment']): ?>
                        <div class="mb-3">
                            <label class="form-label text-white-50">Company Comment</label>
                            <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($application['comment']) ?></textarea>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Company Actions (if company is viewing) -->
                <?php if ($isCompany && $application['status'] === 'pending'): ?>
                    <div class="mb-4">
                        <h4 class="text-white-50 mb-3">
                            <i class="bi bi-gear me-2"></i>Actions
                        </h4>
                        <div class="d-grid gap-2 d-md-flex">
                            <a href="?controller=application&action=update&id=<?= $application['id'] ?>&status=accepted" 
                               class="btn btn-glass btn-outline-success"
                               onclick="return confirm('Accept this application?')">
                                <i class="bi bi-check-circle me-2"></i>Accept Application
                            </a>
                            <a href="?controller=application&action=update&id=<?= $application['id'] ?>&status=rejected" 
                               class="btn btn-glass btn-outline-danger"
                               onclick="return confirm('Reject this application?')">
                                <i class="bi bi-x-circle me-2"></i>Reject Application
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Messages Section -->
                <?php if (!empty($messages)): ?>
                    <div class="mb-4">
                        <h4 class="text-white-50 mb-3">
                            <i class="bi bi-chat-dots me-2"></i>Messages
                        </h4>
                        <div class="messages-container">
                            <?php foreach ($messages as $message): ?>
                                <div class="glass-card p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <strong class="text-warning"><?= htmlspecialchars($message['sender_name']) ?></strong>
                                            <span class="text-white-50 ms-2">(<?= ucfirst($message['sender_type']) ?>)</span>
                                        </div>
                                        <small class="text-white-50"><?= date('M d, Y H:i', strtotime($message['created_at'])) ?></small>
                                    </div>
                                    <div class="message-content">
                                        <?= nl2br(htmlspecialchars($message['content'])) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
  </div>
</div>

<style>
.application-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 221, 51, 0.1);
    border-radius: 50%;
    border: 2px solid var(--accent-yellow);
}

.form-control {
    background: rgba(255, 221, 51, 0.08) !important;
    border: 1px solid var(--glass-border) !important;
    color: var(--accent-yellow) !important;
    backdrop-filter: blur(10px);
}

.form-control:read-only {
    background: rgba(255, 221, 51, 0.05) !important;
    color: rgba(255, 221, 51, 0.7) !important;
}

.form-label {
    color: rgba(255, 221, 51, 0.8) !important;
    font-weight: 500;
}

.message-content {
    color: var(--accent-yellow);
    line-height: 1.6;
    white-space: pre-wrap;
}

.messages-container {
    max-height: 400px;
    overflow-y: auto;
}

.badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}
</style>

<?php include __DIR__ . '/../layout/footer.php'; ?> 