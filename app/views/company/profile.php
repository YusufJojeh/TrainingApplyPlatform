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
        <!-- Profile Card -->
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
                        <a href="?controller=company&action=settings" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-gear me-2"></i>Settings
                        </a>
                        <a href="?controller=company&action=dashboard" class="btn btn-glass btn-outline-info">
                            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="col-lg-8">
            <div class="glass-card p-4">
                <h2 class="gradient-text-yellow mb-4">
                    <i class="bi bi-building-gear me-2"></i>Edit Company Profile
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

                <form method="post" enctype="multipart/form-data" action="?controller=company&action=profile" id="companyProfileForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label text-white-50">
                                <i class="bi bi-building me-2"></i>Company Name
                            </label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= htmlspecialchars($company['name']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label text-white-50">
                                <i class="bi bi-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($company['email']) ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="field" class="form-label text-white-50">
                                <i class="bi bi-briefcase me-2"></i>Field
                            </label>
                            <input type="text" class="form-control" id="field" name="field" 
                                   value="<?= htmlspecialchars($company['field']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label text-white-50">
                                <i class="bi bi-geo-alt me-2"></i>City
                            </label>
                            <input type="text" class="form-control" id="city" name="city" 
                                   value="<?= htmlspecialchars($company['city']) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="website" class="form-label text-white-50">
                            <i class="bi bi-globe me-2"></i>Website
                        </label>
                        <input type="url" class="form-control" id="website" name="website" 
                               value="<?= htmlspecialchars($company['website'] ?? '') ?>" 
                               placeholder="https://yourcompany.com">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label text-white-50">
                            <i class="bi bi-card-text me-2"></i>Company Description
                        </label>
                        <textarea class="form-control" id="description" name="description" rows="4" 
                                  placeholder="Describe your company, mission, and values..."><?= htmlspecialchars($company['description'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="logo" class="form-label text-white-50">
                            <i class="bi bi-image me-2"></i>Company Logo
                        </label>
                        <?php if (!empty($company['logo'])): ?>
                            <div class="mb-2">
                                <img src="<?= htmlspecialchars($company['logo']) ?>" alt="Current Logo" 
                                     class="img-thumbnail" style="max-width: 150px;">
                                <p class="text-white-50 small mt-1">Current logo</p>
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="logo" name="logo" 
                               accept="image/png,image/jpeg,image/jpg,image/gif">
                        <div class="form-text text-white-50">Upload a new logo (PNG, JPG, GIF - max 5MB)</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-glass btn-primary-glass btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
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

.form-control::placeholder {
    color: rgba(255, 221, 51, 0.6) !important;
}

.form-label {
    color: rgba(255, 221, 51, 0.8) !important;
    font-weight: 500;
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}
</style>

<script>
$('#companyProfileForm').on('submit', function(e) {
    let valid = true;
    let firstError = null;
    
    $('.form-control').removeClass('is-invalid').addClass('is-valid');
    
    // Validate required fields
    const requiredFields = ['name', 'email', 'field', 'city'];
    requiredFields.forEach(field => {
        if (!$('#' + field).val().trim()) {
            valid = false;
            $('#' + field).removeClass('is-valid').addClass('is-invalid');
            if (!firstError) firstError = $('#' + field);
        }
    });
    
    // Validate email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if ($('#email').val() && !emailRegex.test($('#email').val())) {
        valid = false;
        $('#email').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#email');
        showNotification('Please enter a valid email address.', 'error');
    }
    
    // Validate website URL if provided
    if ($('#website').val()) {
        const urlRegex = /^https?:\/\/.+/;
        if (!urlRegex.test($('#website').val())) {
            valid = false;
            $('#website').removeClass('is-valid').addClass('is-invalid');
            if (!firstError) firstError = $('#website');
            showNotification('Please enter a valid website URL starting with http:// or https://', 'error');
        }
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
        showNotification('Profile updated successfully!', 'success');
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