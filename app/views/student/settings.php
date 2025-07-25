<?php
// app/views/student/settings.php
include_once __DIR__ . '/../layout/header.php';

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: ?controller=student&action=login');
    exit;
}
?>

<div class="container-fluid py-5 mt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white mb-0">
                        <i class="bi bi-gear me-2"></i>Account Settings
                    </h2>
                    <a href="?controller=student&action=dashboard" class="btn btn-glass btn-outline-warning">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>

                <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Account Information -->
                <div class="mb-4">
                    <h4 class="text-white mb-3">
                        <i class="bi bi-person-circle me-2"></i>Account Information
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white">Username</label>
                            <input type="text" class="form-control glass-input" value="<?= htmlspecialchars($student['username']) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white">Email</label>
                            <input type="email" class="form-control glass-input" value="<?= htmlspecialchars($student['email']) ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white">Name</label>
                            <input type="text" class="form-control glass-input" value="<?= htmlspecialchars($student['name']) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white">Member Since</label>
                            <input type="text" class="form-control glass-input" value="<?= date('M d, Y', strtotime($student['created_at'])) ?>" readonly>
                        </div>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="mb-4">
                    <h4 class="text-white mb-3">
                        <i class="bi bi-lock me-2"></i>Change Password
                    </h4>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label text-white">Current Password</label>
                                <input type="password" class="form-control glass-input" id="current_password" name="current_password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label text-white">New Password</label>
                                <input type="password" class="form-control glass-input" id="new_password" name="new_password" required minlength="6">
                                <div class="form-text text-white">Minimum 6 characters</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label text-white">Confirm New Password</label>
                                <input type="password" class="form-control glass-input" id="confirm_password" name="confirm_password" required minlength="6">
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-glass btn-primary-glass">
                                <i class="bi bi-check-circle me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Actions -->
                <div class="mb-4">
                    <h4 class="text-white mb-3">
                        <i class="bi bi-shield-exclamation me-2"></i>Account Actions
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="glass-card p-3">
                                <h6 class="text-white mb-2">Export Data</h6>
                                <p class="text-white small mb-3">Download your profile and application data</p>
                                <a href="?controller=student&action=export" class="btn btn-sm btn-glass btn-outline-info">
                                    <i class="bi bi-download me-1"></i>Export Data
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="glass-card p-3">
                                <h6 class="text-white mb-2">Delete Account</h6>
                                <p class="text-white small mb-3">Permanently delete your account and all data</p>
                                <button type="button" class="btn btn-sm btn-glass btn-outline-danger" 
                                        onclick="if(confirm('Are you sure? This action cannot be undone.')) window.location.href='?controller=student&action=deleteAccount'">
                                    <i class="bi bi-trash me-1"></i>Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="mb-4">
                    <h4 class="text-white mb-3">
                        <i class="bi bi-bell me-2"></i>Notification Settings
                    </h4>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                        <label class="form-check-label text-white" for="emailNotifications">
                            Email notifications for application updates
                        </label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="messageNotifications" checked>
                        <label class="form-check-label text-white" for="messageNotifications">
                            Notifications for new messages
                        </label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="weeklyDigest">
                        <label class="form-check-label text-white" for="weeklyDigest">
                            Weekly digest of activities
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Student Settings Styles */
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

.glass-input {
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: var(--text-light) !important;
    backdrop-filter: blur(10px);
}

.glass-input:focus {
    background: rgba(255, 255, 255, 0.15) !important;
    border-color: var(--accent-yellow) !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 221, 51, 0.1) !important;
    color: var(--text-light) !important;
}

.glass-input:read-only {
    background: rgba(255, 255, 255, 0.05) !important;
    color: rgba(255, 255, 255, 0.6) !important;
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

.alert {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.alert-success {
    border-color: rgba(40, 167, 69, 0.5);
    color: #28a745;
}

.alert-danger {
    border-color: rgba(220, 53, 69, 0.5);
    color: #dc3545;
}

.form-check-input {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
}

.form-check-input:checked {
    background-color: var(--accent-yellow);
    border-color: var(--accent-yellow);
}

.form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 221, 51, 0.25);
}
</style>

<?php include __DIR__ . '/../layout/footer.php'; ?> 