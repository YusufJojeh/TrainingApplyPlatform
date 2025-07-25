<?php include __DIR__ . '/../layout/header.php'; ?>
<?php
// Check if company is logged in
if (!isset($_SESSION['company_id'])) {
    header('Location: ?controller=company&action=login');
    exit;
}

// Get company data
$companyModel = new Company($GLOBALS['pdo']);
$company = $companyModel->getProfile($_SESSION['company_id']);
?>

<div class="container py-5">
    <div class="row">
        <!-- Settings Card -->
        <div class="col-lg-4 mb-4">
            <div class="glass-card p-4 h-100">
                <div class="text-center mb-4">
                    <div class="profile-avatar mb-3">
                        <?php if (!empty($company['logo'])): ?>
                            <img src="<?= htmlspecialchars($company['logo']) ?>" alt="Company Logo" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        <?php else: ?>
                            <i class="bi bi-building display-1 text-warning"></i>
                        <?php endif; ?>
                    </div>
                    <h3 class="gradient-text-yellow mb-2"><?= htmlspecialchars($company['name']) ?></h3>
                    <p class="text-white-50 mb-1"><?= htmlspecialchars($company['field']) ?></p>
                    <p class="text-white-50 mb-3"><?= htmlspecialchars($company['city']) ?></p>
                    <div class="d-grid gap-2">
                        <a href="?controller=company&action=profile" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-building-gear me-2"></i>Profile
                        </a>
                        <a href="?controller=company&action=dashboard" class="btn btn-glass btn-outline-info">
                            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="col-lg-8">
            <div class="glass-card p-4">
                <h2 class="gradient-text-yellow mb-4">
                    <i class="bi bi-gear me-2"></i>Account Settings
                </h2>

                <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Account Information -->
                <div class="mb-4">
                    <h4 class="text-white-50 mb-3">
                        <i class="bi bi-info-circle me-2"></i>Account Information
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Username</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($company['username']) ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50">Email</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($company['email']) ?>" readonly>
                        </div>
                    </div>
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
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        To update your profile information, please visit the <a href="?controller=company&action=profile" class="alert-link">Profile</a> page.
                    </div>
                </div>

                <!-- Change Password -->
                <div class="mb-4">
                    <h4 class="text-white-50 mb-3">
                        <i class="bi bi-lock me-2"></i>Change Password
                    </h4>
                    <form method="post" action="?controller=company&action=settings" id="passwordChangeForm">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label text-white-50">
                                    <i class="bi bi-key me-2"></i>Current Password
                                </label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label text-white-50">
                                    <i class="bi bi-lock me-2"></i>New Password
                                </label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                                <div class="form-text text-white-50">Minimum 6 characters</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label text-white-50">
                                    <i class="bi bi-lock-fill me-2"></i>Confirm New Password
                                </label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-glass btn-primary-glass btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Change Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Security Information -->
                <div class="mb-4">
                    <h4 class="text-white-50 mb-3">
                        <i class="bi bi-shield-check me-2"></i>Security Information
                    </h4>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Important:</strong> Keep your password secure and never share it with anyone. 
                        The system stores passwords in plain text for demonstration purposes only.
                    </div>
                </div>

                <!-- Account Actions -->
                <div class="mb-4">
                    <h4 class="text-white-50 mb-3">
                        <i class="bi bi-gear-wide-connected me-2"></i>Account Actions
                    </h4>
                    <div class="d-grid gap-2">
                        <a href="?controller=company&action=inbox" class="btn btn-glass btn-outline-info">
                            <i class="bi bi-envelope me-2"></i>View Messages
                        </a>
                        <a href="?controller=company&action=dashboard" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                        </a>
                        <a href="?controller=company&action=logout" class="btn btn-glass btn-outline-danger" 
                           onclick="return confirm('Are you sure you want to logout?')">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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

.form-control {
    background: rgba(255, 221, 51, 0.08) !important;
    border: 1px solid var(--glass-border) !important;
    color: var(--accent-yellow) !important;
    backdrop-filter: blur(10px);
}

.form-control:focus {
    background: rgba(255, 221, 51, 0.15) !important;
    border-color: rgba(255, 221, 51, 0.3) !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 221, 51, 0.1) !important;
    color: var(--accent-yellow) !important;
}

.form-control:read-only {
    background: rgba(255, 221, 51, 0.05) !important;
    color: rgba(255, 221, 51, 0.7) !important;
}

.form-control::placeholder {
    color: rgba(255, 221, 51, 0.6) !important;
}

.form-label {
    color: rgba(255, 221, 51, 0.8) !important;
    font-weight: 500;
}

.alert-info {
    background: rgba(13, 202, 240, 0.1) !important;
    border-color: rgba(13, 202, 240, 0.3) !important;
    color: rgba(255, 255, 255, 0.9) !important;
}

.alert-warning {
    background: rgba(255, 193, 7, 0.1) !important;
    border-color: rgba(255, 193, 7, 0.3) !important;
    color: rgba(255, 255, 255, 0.9) !important;
}

.alert-link {
    color: var(--accent-yellow) !important;
    text-decoration: none;
}

.alert-link:hover {
    color: #fff !important;
    text-decoration: underline;
}
</style>

<script>
$('#passwordChangeForm').on('submit', function(e) {
    let valid = true;
    let firstError = null;
    
    $('.form-control').removeClass('is-invalid').addClass('is-valid');
    
    // Validate current password
    if (!$('#current_password').val()) {
        valid = false;
        $('#current_password').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#current_password');
        showNotification('Please enter your current password.', 'error');
    }
    
    // Validate new password
    if (!$('#new_password').val()) {
        valid = false;
        $('#new_password').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#new_password');
        showNotification('Please enter a new password.', 'error');
    } else if ($('#new_password').val().length < 6) {
        valid = false;
        $('#new_password').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#new_password');
        showNotification('New password must be at least 6 characters long.', 'error');
    }
    
    // Validate confirm password
    if (!$('#confirm_password').val()) {
        valid = false;
        $('#confirm_password').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#confirm_password');
        showNotification('Please confirm your new password.', 'error');
    } else if ($('#new_password').val() !== $('#confirm_password').val()) {
        valid = false;
        $('#confirm_password').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#confirm_password');
        showNotification('New passwords do not match.', 'error');
    }
    
    if (!valid) {
        e.preventDefault();
        if (firstError) {
            firstError.focus();
            $('html, body').animate({
                scrollTop: firstError.offset().top - 100
            }, 500);
        }
    } else {
        showNotification('Password changed successfully!', 'success');
    }
});

function showNotification(message, type) {
    const notification = $(`
        <div class="notification notification-${type} animate__animated animate__fadeInRight">
            <div class="notification-content">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
            </div>
        </div>
    `);
    $('body').append(notification);
    setTimeout(() => {
        notification.addClass('animate__fadeOutRight');
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?> 