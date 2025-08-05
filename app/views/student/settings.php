<?php
// app/views/student/settings.php
include_once __DIR__ . '/../layout/header.php';

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: ?controller=student&action=login');
    exit;
}
?>

<div class="main-content">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="glass-card p-4 animate__animated animate__fadeInUp">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="gradient-text-yellow mb-0">
                            <i class="bi bi-gear me-2"></i>Account Settings
                        </h2>
                        <a href="?controller=student&action=dashboard" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInUp" role="alert">
                            <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInUp" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Account Information -->
                    <div class="mb-4">
                        <h4 class="gradient-text-yellow mb-3">
                            <i class="bi bi-person-circle me-2"></i>Account Information
                        </h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">Username</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($student['username']) ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">Email</label>
                                <input type="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">Name</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">Member Since</label>
                                <input type="text" class="form-control" value="<?= date('M d, Y', strtotime($student['created_at'])) ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="mb-4">
                        <h4 class="gradient-text-yellow mb-3">
                            <i class="bi bi-lock me-2"></i>Change Password
                        </h4>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="current_password" class="form-label text-white-50">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="new_password" class="form-label text-white-50">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                                    <div class="form-text text-white-50">Minimum 6 characters</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirm_password" class="form-label text-white-50">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
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
                        <h4 class="gradient-text-yellow mb-3">
                            <i class="bi bi-shield-exclamation me-2"></i>Account Actions
                        </h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="glass-card p-3">
                                    <h6 class="gradient-text-yellow mb-2">Export Data</h6>
                                    <p class="text-white-50 small mb-3">Download your profile and application data</p>
                                    <a href="?controller=student&action=export" class="btn btn-sm btn-glass btn-outline-info">
                                        <i class="bi bi-download me-1"></i>Export Data
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="glass-card p-3">
                                    <h6 class="gradient-text-yellow mb-2">Delete Account</h6>
                                    <p class="text-white-50 small mb-3">Permanently delete your account and all data</p>
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
                        <h4 class="gradient-text-yellow mb-3">
                            <i class="bi bi-bell me-2"></i>Notification Settings
                        </h4>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                            <label class="form-check-label text-white-50" for="emailNotifications">
                                Email notifications for application updates
                            </label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="messageNotifications" checked>
                            <label class="form-check-label text-white-50" for="messageNotifications">
                                Notifications for new messages
                            </label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="weeklyDigest">
                            <label class="form-check-label text-white-50" for="weeklyDigest">
                                Weekly digest of activities
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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