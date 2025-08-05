<?php include __DIR__ . '/../layout/header.php'; ?>
<?php
// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ?controller=admin&action=login');
    exit;
}

// Get admin data
$adminModel = new Admin($GLOBALS['pdo']);
$students = $adminModel->getAllStudents();
$companies = $adminModel->getAllCompanies();
$applications = $adminModel->getAllApplications();
?>

<div class="main-content">
    <div class="container py-5">
        <!-- Welcome Section -->
        <div class="glass-card p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="gradient-text-yellow mb-2">Admin Dashboard</h1>
                    <p class="text-white-50 mb-0">Welcome back, <?= htmlspecialchars($_SESSION['admin_username']) ?>!</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="?controller=admin&action=logout" class="btn btn-glass btn-outline-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="glass-card p-3 text-center">
                    <i class="bi bi-people display-4 text-warning mb-2"></i>
                    <h3 class="gradient-text-yellow"><?= count($students) ?></h3>
                    <p class="text-white-50 mb-0">Total Students</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-3 text-center">
                    <i class="bi bi-building display-4 text-warning mb-2"></i>
                    <h3 class="gradient-text-yellow"><?= count($companies) ?></h3>
                    <p class="text-white-50 mb-0">Total Companies</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-3 text-center">
                    <i class="bi bi-file-earmark-text display-4 text-warning mb-2"></i>
                    <h3 class="gradient-text-yellow"><?= count($applications) ?></h3>
                    <p class="text-white-50 mb-0">Total Applications</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-3 text-center">
                    <i class="bi bi-clock display-4 text-warning mb-2"></i>
                    <h3 class="gradient-text-yellow">
                        <?= count(array_filter($applications, fn($app) => $app['status'] === 'pending')) ?>
                    </h3>
                    <p class="text-white-50 mb-0">Pending Applications</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="glass-card p-4">
                    <h3 class="gradient-text-yellow mb-3">Quick Actions</h3>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="?controller=admin&action=students" class="btn btn-glass btn-primary-glass w-100">
                                <i class="bi bi-people me-2"></i>Manage Students
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="?controller=admin&action=companies" class="btn btn-glass btn-primary-glass w-100">
                                <i class="bi bi-building me-2"></i>Manage Companies
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="?controller=admin&action=applications" class="btn btn-glass btn-primary-glass w-100">
                                <i class="bi bi-file-earmark-text me-2"></i>View Applications
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="?controller=admin&action=logs" class="btn btn-glass btn-primary-glass w-100">
                                <i class="bi bi-list-check me-2"></i>System Logs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="row">
            <div class="col-12">
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="gradient-text-yellow mb-0">Recent Applications</h3>
                        <a href="?controller=admin&action=applications" class="btn btn-glass btn-outline-warning">
                            View All
                        </a>
                    </div>

                    <?php if (empty($applications)): ?>
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-white-50 mb-3"></i>
                            <h4 class="text-white-50">No Applications Yet</h4>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-dark align-middle glass-card animate__animated animate__fadeIn">
                                <thead>
                                    <tr>
                                        <th class="text-white">Student</th>
                                        <th class="text-white">Company</th>
                                        <th class="text-white">Status</th>
                                        <th class="text-white">Date</th>
                                        <th class="text-white">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $recent_applications = array_slice($applications, 0, 5);
                                    foreach ($recent_applications as $app): 
                                    ?>
                                        <tr>
                                            <td class="text-white align-middle">
                                                <strong class="text-warning"><?= htmlspecialchars($app['student_name']) ?></strong>
                                            </td>
                                            <td class="text-white-50 align-middle">
                                                <?= htmlspecialchars($app['company_name']) ?>
                                            </td>
                                            <td class="align-middle">
                                                <?php
                                                $statusClass = match($app['status']) {
                                                    'accepted' => 'success',
                                                    'rejected' => 'danger',
                                                    default => 'warning'
                                                };
                                                $statusText = ucfirst($app['status']);
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?> text-white fw-bold"><?= $statusText ?></span>
                                            </td>
                                            <td class="text-white-50 align-middle">
                                                <?= date('M d, Y', strtotime($app['created_at'])) ?>
                                            </td>
                                            <td class="align-middle">
                                                <a href="?controller=application&action=detail&id=<?= $app['id'] ?>" 
                                                   class="btn btn-sm btn-outline-warning text-white">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?> 