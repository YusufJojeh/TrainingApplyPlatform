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
?>

<!-- Student Dashboard Navbar -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark fixed-top student-navbar">
    <div class="container">
        <a class="navbar-brand" href="?controller=student&action=dashboard">
            <i class="bi bi-mortarboard-fill me-2"></i>Student Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#studentNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="studentNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="?controller=student&action=dashboard">
                        <i class="bi bi-house-door me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=student&action=composeMessage">
                        <i class="bi bi-plus-circle me-1"></i>Apply
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=message&action=inbox">
                        <i class="bi bi-envelope me-1"></i>Messages
                        <?php if ($unreadMessages > 0): ?>
                            <span class="badge bg-danger ms-1"><?= $unreadMessages ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=student&action=profile">
                        <i class="bi bi-person me-1"></i>Profile
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($student['name']) ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="?controller=student&action=profile">
                            <i class="bi bi-person me-2"></i>My Profile
                        </a></li>
                        <li><a class="dropdown-item" href="?controller=student&action=settings">
                            <i class="bi bi-gear me-2"></i>Settings
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="?controller=student&action=logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav> -->

<div class="container-fluid py-5 mt-5">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="glass-card p-4 text-center">
                <h1 class="text-white mb-2">Welcome back, <?= htmlspecialchars($student['name']) ?>!</h1>
                <p class="text-white mb-0">Track your applications and connect with companies</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="glass-card p-4 text-center h-100">
                <div class="stat-icon mb-3">
                    <i class="bi bi-file-earmark-text display-4 text-warning"></i>
                </div>
                <h3 class="text-white mb-1"><?= $totalApplications ?></h3>
                <p class="text-white mb-0">Total Applications</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="glass-card p-4 text-center h-100">
                <div class="stat-icon mb-3">
                    <i class="bi bi-clock display-4 text-warning"></i>
                </div>
                <h3 class="text-white mb-1"><?= $pendingApplications ?></h3>
                <p class="text-white mb-0">Pending</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="glass-card p-4 text-center h-100">
                <div class="stat-icon mb-3">
                    <i class="bi bi-check-circle display-4 text-success"></i>
                </div>
                <h3 class="text-white mb-1"><?= $acceptedApplications ?></h3>
                <p class="text-white mb-0">Accepted</p>
            </div>
                    </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="glass-card p-4 text-center h-100">
                <div class="stat-icon mb-3">
                    <i class="bi bi-envelope display-4 text-info"></i>
                </div>
                <h3 class="text-white mb-1"><?= count($companyResponses) ?></h3>
                <p class="text-white mb-0">Responses</p>
                </div>
            </div>
        </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Applications Section -->
        <div class="col-lg-8 mb-4">
            <div class="glass-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white mb-0">
                        <i class="bi bi-briefcase me-2"></i>My Applications
                    </h2>
                    <a href="?controller=student&action=composeMessage" class="btn btn-glass btn-primary-glass">
                        <i class="bi bi-plus-circle me-2"></i>New Application
                    </a>
                </div>

                <?php if (empty($applications)): ?>
                    <div class="text-center py-5">
                        <div class="empty-state mb-4">
                            <i class="bi bi-inbox display-1 text-white"></i>
                        </div>
                        <h4 class="text-white mb-3">No Applications Yet</h4>
                        <p class="text-white mb-4">Start your journey by applying to companies!</p>
                        <a href="?controller=application&action=create" class="btn btn-glass btn-primary-glass">
                            <i class="bi bi-rocket-takeoff me-2"></i>Apply Now
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th class="text-white">Company</th>
                                    <th class="text-white">Status</th>
                                    <th class="text-white">Applied Date</th>
                                    <th class="text-white">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applications as $app): ?>
                                    <tr>
                                        <td>
                                            <strong class="text-warning"><?= htmlspecialchars($app['company_name']) ?></strong>
                                        </td>
                                        <td>
                                            <?php
                                            $statusClass = match($app['status']) {
                                                'accepted' => 'success',
                                                'rejected' => 'danger',
                                                default => 'warning'
                                            };
                                            $statusText = ucfirst($app['status']);
                                            ?>
                                            <span class="badge bg-<?= $statusClass ?>"><?= $statusText ?></span>
                                        </td>
                                        <td class="text-white">
                                            <?= date('M d, Y', strtotime($app['created_at'])) ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                            <a href="?controller=application&action=detail&id=<?= $app['id'] ?>" 
                                               class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-eye me-1"></i>View
                                            </a>
                                                <?php if ($app['status'] === 'pending'): ?>
                                                    <a href="?controller=message&action=sendApplication&company_id=<?= $app['company_id'] ?>&application_id=<?= $app['id'] ?>" 
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-envelope me-1"></i>Message
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 mb-4">
            <!-- Profile Card -->
            <div class="glass-card p-4 mb-4">
                <div class="text-center mb-4">
                    <div class="profile-avatar mb-3">
                        <i class="bi bi-person-circle display-1 text-warning"></i>
                    </div>
                    <h3 class="text-white mb-2"><?= htmlspecialchars($student['name']) ?></h3>
                    <p class="text-white mb-1"><?= htmlspecialchars($student['major']) ?></p>
                    <p class="text-white mb-3"><?= htmlspecialchars($student['city']) ?></p>
                    <div class="d-grid gap-2">
                        <a href="?controller=student&action=profile" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-pencil-square me-2"></i>Edit Profile
                        </a>
        </div>
    </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass-card p-4 mb-4">
                <h4 class="text-white mb-3">
                    <i class="bi bi-lightning me-2"></i>Quick Actions
                </h4>
                <div class="d-grid gap-2">
                    <a href="?controller=student&action=composeMessage" class="btn btn-glass btn-outline-primary">
                        <i class="bi bi-plus-circle me-2"></i>Apply to Company
                    </a>
                    <a href="?controller=message&action=inbox" class="btn btn-glass btn-outline-info">
                        <i class="bi bi-envelope me-2"></i>View Messages
                        <?php if ($unreadMessages > 0): ?>
                            <span class="badge bg-danger ms-1"><?= $unreadMessages ?></span>
                        <?php endif; ?>
                    </a>
                                            <a href="?controller=student&action=settings" class="btn btn-glass btn-outline-secondary">
                            <i class="bi bi-gear me-2"></i>Settings
                        </a>
                        <a href="?controller=student&action=composeMessage" class="btn btn-glass btn-outline-info">
                            <i class="bi bi-envelope-plus me-2"></i>Compose Message
                        </a>
                </div>
            </div>

            <!-- Recent Responses -->
            <div class="glass-card p-4">
                <h4 class="text-white mb-3">
                    <i class="bi bi-chat-dots me-2"></i>Recent Responses
                </h4>
                <?php if (empty($companyResponses)): ?>
                    <p class="text-white mb-0">No responses yet.</p>
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
                                        <p class="text-white mb-1 small"><?= htmlspecialchars($msg['content']) ?></p>
                                    </div>
                                    <small class="text-white"><?= date('M d', strtotime($msg['created_at'])) ?></small>
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

<style>
/* Student Dashboard Styles */
.student-navbar {
    background: rgba(0, 0, 0, 0.8) !important;
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 221, 51, 0.2);
}

.student-navbar .navbar-brand {
    color: var(--accent-yellow) !important;
    font-weight: bold;
}

.student-navbar .nav-link {
    color: rgba(255, 255, 255, 0.8) !important;
    transition: color 0.3s ease;
}

.student-navbar .nav-link:hover,
.student-navbar .nav-link.active {
    color: var(--accent-yellow) !important;
}

.glass-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.stat-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 221, 51, 0.1);
    border-radius: 50%;
    border: 2px solid var(--accent-yellow);
}

.profile-avatar {
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

.empty-state {
    width: 120px;
    height: 120px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.1);
}

.responses-list {
    max-height: 300px;
    overflow-y: auto;
}

.response-item {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 0.5rem;
    transition: background 0.3s ease;
}

.response-item:hover {
    background: rgba(255, 255, 255, 0.1);
}

.btn-glass {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: var(--text-light);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.btn-glass:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: var(--text-light);
}

.btn-primary-glass {
    background: rgba(255, 221, 51, 0.2);
    border-color: var(--accent-yellow);
    color: var(--accent-yellow);
}

.btn-primary-glass:hover {
    background: rgba(255, 221, 51, 0.3);
    border-color: var(--accent-yellow);
    color: var(--accent-yellow);
}

.btn-outline-warning {
    border-color: var(--accent-yellow);
    color: var(--accent-yellow);
}

.btn-outline-warning:hover {
    background: var(--accent-yellow);
    border-color: var(--accent-yellow);
    color: #000;
}

.table-dark {
    background: transparent;
    color: var(--text-light);
}

.table-dark th,
.table-dark td {
    border-color: rgba(255, 255, 255, 0.1);
}

.dropdown-menu-dark {
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.dropdown-item {
    color: rgba(255, 255, 255, 0.8);
}

.dropdown-item:hover {
    background: rgba(255, 221, 51, 0.1);
    color: var(--accent-yellow);
}

table {
    background: transparent !important;
    color: #fff !important;
}
</style>

<?php include __DIR__ . '/../layout/footer.php'; ?> 