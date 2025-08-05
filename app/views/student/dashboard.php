<?php include __DIR__ . '/../layout/header.php'; ?>
<?php
// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: ?controller=student&action=login');
    exit;
}

// Get student data
$studentModel = new Student($GLOBALS['pdo']);
$student = $studentModel->getProfile($_SESSION['student_id']);

// Get student applications
$applicationModel = new Application($GLOBALS['pdo']);
$applications = $applicationModel->getByStudent($_SESSION['student_id']);

// Get student messages
$messageModel = new Message($GLOBALS['pdo']);
$studentMessages = $messageModel->getByUser($_SESSION['student_id'], 'student');
$companyResponses = array_filter($studentMessages, function($msg) {
    return $msg['sender_type'] === 'company';
});

// Calculate stats
$totalApplications = count($applications);
$acceptedApplications = count(array_filter($applications, fn($app) => $app['status'] === 'accepted'));
$pendingApplications = count(array_filter($applications, fn($app) => $app['status'] === 'pending'));
$rejectedApplications = count(array_filter($applications, fn($app) => $app['status'] === 'rejected'));
$unreadMessages = count(array_filter($studentMessages, function($msg) {
    return $msg['sender_type'] === 'company' && !isset($msg['is_read']);
}));

// Calculate additional stats
$thisWeekApplications = count(array_filter($applications, fn($app) => strtotime($app['created_at']) > strtotime('-7 days')));
$thisMonthApplications = count(array_filter($applications, fn($app) => strtotime($app['created_at']) > strtotime('-30 days')));
$acceptanceRate = $totalApplications > 0 ? round(($acceptedApplications / $totalApplications) * 100, 1) : 0;

// Handle success/error messages
$successMessage = '';
$errorMessage = '';

if (isset($_GET['msg']) && $_GET['msg'] === 'applied') {
    $successMessage = "Application submitted successfully!";
}

if (isset($_GET['error']) && $_GET['error'] === 'failed') {
    $errorMessage = "Failed to submit application. Please try again.";
}
?>

<div class="main-content">
    <div class="container py-5">
        <!-- Success/Error Messages -->
        <?php if ($successMessage): ?>
            <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInUp">
                <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($successMessage) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInUp">
                <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($errorMessage) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Dashboard Header -->
        <div class="glass-card p-4 mb-4 animate__animated animate__fadeInUp">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="gradient-text-yellow mb-2">Welcome back, <?= htmlspecialchars($student['name']) ?>!</h1>
                    <p class="text-white-50 mb-0">Track your applications and connect with companies for your dream internship</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="profile-avatar">
                        <i class="bi bi-mortarboard-fill display-4 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2"><?= $totalApplications ?></div>
                    <div class="text-white-50">Total Applications</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2"><?= $pendingApplications ?></div>
                    <div class="text-white-50">Pending Review</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2"><?= $acceptedApplications ?></div>
                    <div class="text-white-50">Accepted</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp animate__delay-3s">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2"><?= count($companyResponses) ?></div>
                    <div class="text-white-50">Responses</div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <?php if ($totalApplications > 0): ?>
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp">
                    <div class="stat-number display-5 fw-bold gradient-text-yellow mb-2"><?= $acceptanceRate ?>%</div>
                    <div class="text-white-50">Acceptance Rate</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="stat-number display-5 fw-bold gradient-text-yellow mb-2"><?= $thisWeekApplications ?></div>
                    <div class="text-white-50">This Week</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="stat-number display-5 fw-bold gradient-text-yellow mb-2"><?= $unreadMessages ?></div>
                    <div class="text-white-50">Unread Messages</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Main Content -->
        <div class="row">
            <!-- Applications Section -->
            <div class="col-lg-8">
                <div class="glass-card p-4 animate__animated animate__fadeInUp">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="gradient-text-yellow mb-1">
                                <i class="bi bi-briefcase me-2"></i>My Applications
                            </h3>
                            <p class="text-white-50 mb-0">Track your internship applications and responses</p>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-glass btn-outline-warning active" data-filter="all">All</button>
                            <button type="button" class="btn btn-glass btn-outline-warning" data-filter="pending">Pending</button>
                            <button type="button" class="btn btn-glass btn-outline-success" data-filter="accepted">Accepted</button>
                            <button type="button" class="btn btn-glass btn-outline-danger" data-filter="rejected">Rejected</button>
                        </div>
                    </div>

                    <?php if (empty($applications)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-white-50 mb-3"></i>
                            <h4 class="text-white-50 mb-3">No Applications Yet</h4>
                            <p class="text-white-50 mb-4">Start your journey by applying to companies!</p>
                            <a href="?controller=application&action=create" class="btn btn-glass btn-primary-glass">
                                <i class="bi bi-rocket-takeoff me-2"></i>Apply Now
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-dark align-middle glass-card animate__animated animate__fadeIn">
                                <thead>
                                    <tr>
                                        <th class="text-white">Company</th>
                                        <th class="text-white">Field</th>
                                        <th class="text-white">Applied Date</th>
                                        <th class="text-white">Status</th>
                                        <th class="text-white">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($applications as $app): ?>
                                    <tr class="application-item" data-status="<?= $app['status'] ?? 'pending' ?>">
                                        <td class="text-white align-middle">
                                            <strong class="text-warning"><?= htmlspecialchars($app['company_name']) ?></strong>
                                        </td>
                                        <td class="text-white-50 align-middle"><?= htmlspecialchars($app['field'] ?? 'N/A') ?></td>
                                        <td class="text-white-50 align-middle"><?= date('M d, Y', strtotime($app['created_at'])) ?></td>
                                        <td class="align-middle">
                                            <?php
                                            $statusClass = match($app['status'] ?? 'pending') {
                                                'accepted' => 'success',
                                                'rejected' => 'danger',
                                                default => 'warning'
                                            };
                                            $statusText = ucfirst($app['status'] ?? 'pending');
                                            ?>
                                            <span class="badge bg-<?= $statusClass ?> text-white fw-bold"><?= $statusText ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-2">
                                                <a href="?controller=application&action=detail&id=<?= $app['id'] ?>" 
                                                   class="btn btn-sm btn-glass btn-outline-warning text-white" 
                                                   data-bs-toggle="tooltip" title="View details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php if (($app['status'] ?? 'pending') === 'pending'): ?>
                                                    <a href="?controller=message&action=sendApplication&company_id=<?= $app['company_id'] ?>&application_id=<?= $app['id'] ?>" 
                                                       class="btn btn-sm btn-glass btn-outline-info text-white"
                                                       data-bs-toggle="tooltip" title="Send message">
                                                        <i class="bi bi-envelope"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <?php if (count($applications) > 10): ?>
                            <div class="text-center mt-4">
                                <a href="?controller=application&action=list" class="btn btn-glass btn-primary-glass">
                                    <i class="bi bi-arrow-right me-2"></i>View All Applications (<?= $totalApplications ?>)
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="glass-card p-4 mb-4 animate__animated animate__fadeInUp">
                    <div class="text-center mb-4">
                        <div class="profile-avatar mb-3">
                            <i class="bi bi-mortarboard-fill display-1 text-warning"></i>
                        </div>
                        <h3 class="gradient-text-yellow mb-2"><?= htmlspecialchars($student['name']) ?></h3>
                        <p class="text-white-50 mb-1"><?= htmlspecialchars($student['major']) ?></p>
                        <p class="text-white-50 mb-3">
                            <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($student['city']) ?>
                        </p>
                        <div class="d-grid gap-2">
                            <a href="?controller=student&action=profile" class="btn btn-glass btn-outline-warning">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="glass-card p-4 mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                    <h5 class="gradient-text-yellow mb-3">
                        <i class="bi bi-lightning me-2"></i>Quick Actions
                    </h5>
                    <div class="d-grid gap-2">
                        <a href="?controller=application&action=create" class="btn btn-glass btn-primary-glass">
                            <i class="bi bi-plus-circle me-2"></i>Apply to Company
                        </a>
                        <a href="?controller=message&action=inbox" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-envelope me-2"></i>View Messages
                            <?php if ($unreadMessages > 0): ?>
                                <span class="badge bg-danger ms-1"><?= $unreadMessages ?></span>
                            <?php endif; ?>
                        </a>
                        <a href="?controller=student&action=composeMessage" class="btn btn-glass btn-outline-info">
                            <i class="bi bi-envelope-plus me-2"></i>Compose Message
                        </a>
                        <a href="?controller=student&action=settings" class="btn btn-glass btn-outline-secondary">
                            <i class="bi bi-gear me-2"></i>Settings
                        </a>
                    </div>
                </div>

                <!-- Recent Responses -->
                <div class="glass-card p-4 animate__animated animate__fadeInUp animate__delay-2s">
                    <h5 class="gradient-text-yellow mb-3">
                        <i class="bi bi-chat-dots me-2"></i>Recent Responses
                    </h5>
                    <?php if (empty($companyResponses)): ?>
                        <div class="text-center py-3">
                            <i class="bi bi-inbox text-white-50 mb-2"></i>
                            <p class="text-white-50 mb-0">No responses yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="responses-list">
                            <?php 
                            $recentResponses = array_slice($companyResponses, 0, 3);
                            foreach ($recentResponses as $msg): 
                            ?>
                                <div class="response-item mb-3 p-3 border-start border-warning">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong class="text-warning">Company #<?= htmlspecialchars($msg['sender_id']) ?></strong>
                                            <p class="text-white-50 mb-1 small"><?= htmlspecialchars(substr($msg['content'], 0, 100)) ?>...</p>
                                        </div>
                                        <small class="text-white-50"><?= date('M d', strtotime($msg['created_at'])) ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (count($companyResponses) > 3): ?>
                                <a href="?controller=message&action=inbox" class="btn btn-sm btn-outline-warning w-100">
                                    View All Responses
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Filter functionality
document.querySelectorAll('[data-filter]').forEach(button => {
    button.addEventListener('click', function() {
        const filter = this.dataset.filter;
        
        // Update active button
        document.querySelectorAll('[data-filter]').forEach(btn => {
            btn.classList.remove('active');
        });
        this.classList.add('active');
        
        // Filter applications
        document.querySelectorAll('.application-item').forEach(item => {
            const status = item.dataset.status || 'pending';
            const shouldShow = filter === 'all' || status === filter;
            item.style.display = shouldShow ? 'table-row' : 'none';
        });
    });
});

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Auto-hide alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?> 