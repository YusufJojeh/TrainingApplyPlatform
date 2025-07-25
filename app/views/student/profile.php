<?php
// app/views/student/profile.php
include __DIR__ . '/../layout/header.php';

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: ?controller=student&action=login');
    exit;
}
?>

<!-- Student Profile Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top student-navbar">
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
                    <a class="nav-link" href="?controller=student&action=dashboard">
                        <i class="bi bi-house-door me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="?controller=student&action=profile">
                        <i class="bi bi-person me-1"></i>Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=student&action=settings">
                        <i class="bi bi-gear me-1"></i>Settings
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
</nav>

<div class="container-fluid py-5 mt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white mb-0">
                        <i class="bi bi-person-circle me-2"></i>My Profile
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

                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label text-white">Full Name</label>
                            <input type="text" class="form-control glass-input" id="name" name="name" 
                                   value="<?= htmlspecialchars($student['name']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label text-white">Email Address</label>
                            <input type="email" class="form-control glass-input" id="email" name="email" 
                                   value="<?= htmlspecialchars($student['email']) ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="major" class="form-label text-white">Major/Field of Study</label>
                            <input type="text" class="form-control glass-input" id="major" name="major" 
                                   value="<?= htmlspecialchars($student['major']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label text-white">City</label>
                            <input type="text" class="form-control glass-input" id="city" name="city" 
                                   value="<?= htmlspecialchars($student['city']) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="linkedin" class="form-label text-white">LinkedIn Profile URL</label>
                        <input type="url" class="form-control glass-input" id="linkedin" name="linkedin" 
                               value="<?= htmlspecialchars($student['linkedin'] ?? '') ?>" 
                               placeholder="https://linkedin.com/in/yourprofile">
                    </div>

                    <div class="mb-4">
                        <label for="cv" class="form-label text-white">CV/Resume (PDF)</label>
                        <?php if (!empty($student['cv'])): ?>
                            <div class="mb-2">
                                <a href="<?= htmlspecialchars($student['cv']) ?>" target="_blank" 
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-file-earmark-pdf me-1"></i>View Current CV
                                </a>
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control glass-input" id="cv" name="cv" 
                               accept="application/pdf">
                        <div class="form-text text-white">Upload a new CV to replace the current one (PDF only, max 2MB)</div>
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

<style>
/* Student Profile Styles */
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

.glass-input::placeholder {
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
</style>

<?php include __DIR__ . '/../layout/footer.php'; ?> 