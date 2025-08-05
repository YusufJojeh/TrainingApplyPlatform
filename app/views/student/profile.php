<?php
// app/views/student/profile.php
include __DIR__ . '/../layout/header.php';

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
                            <i class="bi bi-person-circle me-2"></i>My Profile
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

                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label text-white-50">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= htmlspecialchars($student['name']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label text-white-50">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($student['email']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="major" class="form-label text-white-50">Major/Field of Study</label>
                                <input type="text" class="form-control" id="major" name="major" 
                                       value="<?= htmlspecialchars($student['major']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label text-white-50">City</label>
                                <input type="text" class="form-control" id="city" name="city" 
                                       value="<?= htmlspecialchars($student['city']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="linkedin" class="form-label text-white-50">LinkedIn Profile URL</label>
                            <input type="url" class="form-control" id="linkedin" name="linkedin" 
                                   value="<?= htmlspecialchars($student['linkedin'] ?? '') ?>" 
                                   placeholder="https://linkedin.com/in/yourprofile">
                        </div>

                        <div class="mb-4">
                            <label for="cv" class="form-label text-white-50">CV/Resume (PDF)</label>
                            <?php if (!empty($student['cv'])): ?>
                                <div class="mb-2">
                                    <a href="<?= htmlspecialchars($student['cv']) ?>" target="_blank" 
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>View Current CV
                                    </a>
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="cv" name="cv" 
                                   accept="application/pdf">
                            <div class="form-text text-white-50">Upload a new CV to replace the current one (PDF only, max 2MB)</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-glass btn-primary-glass">
                                <i class="bi bi-check-circle me-2"></i>Save Changes
                            </button>
                            <a href="?controller=student&action=dashboard" class="btn btn-glass btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
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