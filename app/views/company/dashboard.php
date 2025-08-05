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

// Get company applications
$applicationModel = new Application($GLOBALS['pdo']);
$applications = $applicationModel->getByCompany($_SESSION['company_id']);

// Calculate application counts
$totalApplications = count($applications);
$pendingApplications = count(array_filter($applications, fn($app) => $app['status'] === 'pending'));
$acceptedApplications = count(array_filter($applications, fn($app) => $app['status'] === 'accepted'));
$rejectedApplications = count(array_filter($applications, fn($app) => $app['status'] === 'rejected'));

// Get recent applications (last 10 for better performance)
$recentApplications = array_slice($applications, 0, 10);

// Handle success/error messages
$successMessage = '';
$errorMessage = '';

if (isset($_GET['msg']) && $_GET['msg'] === 'updated') {
    $status = $_GET['status'] ?? 'updated';
    $successMessage = "Application status updated to " . ucfirst($status) . " successfully!";
}

if (isset($_GET['error']) && $_GET['error'] === 'invalid') {
    $errorMessage = "Invalid application or insufficient permissions.";
}

// Calculate additional stats
$thisWeekApplications = count(array_filter($applications, fn($app) => strtotime($app['created_at']) > strtotime('-7 days')));
$thisMonthApplications = count(array_filter($applications, fn($app) => strtotime($app['created_at']) > strtotime('-30 days')));
$acceptanceRate = $totalApplications > 0 ? round(($acceptedApplications / $totalApplications) * 100, 1) : 0;
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
        <div class="glass-card p-4 mt-2 animate__animated animate__fadeInUp ">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="gradient-text-yellow mt-2">Welcome, <?= htmlspecialchars($company['name'] ?? 'Company') ?>!</h1>
                    <p class="text-white-50 mb-0">Manage your internship applications and track your company's performance</p>
                </div>
               
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mt-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2"><?= $totalApplications ?></div>
                    <div class="text-white-50">Total Applications</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mt-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2"><?= $pendingApplications ?></div>
                    <div class="text-white-50">Pending Review</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mt-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2"><?= $acceptedApplications ?></div>
                    <div class="text-white-50">Accepted</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mt-3">
                <div class="glass-card p-3 text-center animate__animated animate__fadeInUp animate__delay-3s">
                    <div class="stat-number display-4 fw-bold gradient-text-yellow mb-2"><?= $rejectedApplications ?></div>
                    <div class="text-white-50">Rejected</div>
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
                    <div class="stat-number display-5 fw-bold gradient-text-yellow mb-2"><?= $thisMonthApplications ?></div>
                    <div class="text-white-50">This Month</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Applications Section -->
        <div class="row">
            <div class="col-lg-8">
                <div class="glass-card p-4 animate__animated animate__fadeInUp">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="gradient-text-yellow mb-1">Recent Applications</h3>
                            <p class="text-white-50 mb-0">Latest student applications for your review</p>
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
                            <p class="text-white-50 mb-4">Students will be able to apply to your company once you're fully set up!</p>
                            <a href="?controller=company&action=profile" class="btn btn-glass btn-primary-glass">
                                <i class="bi bi-building-gear me-2"></i>Complete Your Profile
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-dark align-middle glass-card animate__animated animate__fadeIn">
                                <thead>
                                    <tr>
                                        <th class="text-white">Student</th>
                                        <th class="text-white">Major</th>
                                        <th class="text-white">Date Applied</th>
                                        <th class="text-white">Status</th>
                                        <th class="text-white">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentApplications as $app): ?>
                                    <tr class="application-item" data-status="<?= $app['status'] ?? 'pending' ?>">
                                        <td class="text-white align-middle">
                                            <strong class="text-warning"><?= htmlspecialchars($app['student_name']) ?></strong>
                                        </td>
                                        <td class="text-white-50 align-middle"><?= htmlspecialchars($app['major'] ?? 'N/A') ?></td>
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
                                                    <a href="?controller=application&action=update&id=<?= $app['id'] ?>&status=accepted" 
                                                       class="btn btn-sm btn-glass btn-outline-success text-white"
                                                       data-bs-toggle="tooltip" title="Accept application"
                                                       onclick="return confirm('Accept this application from <?= htmlspecialchars($app['student_name']) ?>?')">
                                                        <i class="bi bi-check-circle"></i>
                                                    </a>
                                                    <a href="?controller=application&action=update&id=<?= $app['id'] ?>&status=rejected" 
                                                       class="btn btn-sm btn-glass btn-outline-danger text-white"
                                                       data-bs-toggle="tooltip" title="Reject application"
                                                       onclick="return confirm('Reject this application from <?= htmlspecialchars($app['student_name']) ?>?')">
                                                        <i class="bi bi-x-circle"></i>
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
                <!-- Quick Actions -->
                <div class="glass-card p-4 mb-4 animate__animated animate__fadeInUp">
                    <h5 class="gradient-text-yellow mb-3">
                        <i class="bi bi-lightning me-2"></i>Quick Actions
                    </h5>
                    <div class="d-grid gap-2">
                        <a href="?controller=company&action=composeMessage" class="btn btn-glass btn-primary-glass">
                            <i class="bi bi-envelope-plus me-2"></i>Send Message
                        </a>
                        <a href="?controller=company&action=inbox" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-inbox me-2"></i>View Inbox
                        </a>
                        <a href="?controller=application&action=list" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-list-ul me-2"></i>All Applications
                        </a>
                        <a href="?controller=company&action=profile" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-building-gear me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="glass-card p-4 mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                    <h5 class="gradient-text-yellow mb-3">
                        <i class="bi bi-building me-2"></i>Company Info
                    </h5>
                    <div class="text-center">
                        <h6 class="gradient-text-yellow"><?= htmlspecialchars($company['name']) ?></h6>
                        <p class="text-white-50 mb-1"><?= htmlspecialchars($company['field']) ?></p>
                        <p class="text-white-50 mb-3">
                            <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($company['city']) ?>
                        </p>
                    </div>
                </div>

                <!-- Activity Summary -->
                <div class="glass-card p-4 animate__animated animate__fadeInUp animate__delay-2s">
                    <h5 class="gradient-text-yellow mb-3">
                        <i class="bi bi-graph-up me-2"></i>Activity Summary
                    </h5>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-number display-6 fw-bold gradient-text-yellow"><?= $thisWeekApplications ?></div>
                            <div class="text-white-50" style="font-size: 0.9rem;">This Week</div>
                        </div>
                        <div class="col-4">
                            <div class="stat-number display-6 fw-bold gradient-text-yellow"><?= $thisMonthApplications ?></div>
                            <div class="text-white-50" style="font-size: 0.9rem;">This Month</div>
                        </div>
                        <div class="col-4">
                            <div class="stat-number display-6 fw-bold gradient-text-yellow"><?= $totalApplications ?></div>
                            <div class="text-white-50" style="font-size: 0.9rem;">Total</div>
                        </div>
                    </div>
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

// Add loading states for action buttons
document.querySelectorAll('.btn-success, .btn-danger').forEach(btn => {
    btn.addEventListener('click', function() {
        this.innerHTML = '<i class="bi bi-hourglass-split"></i>';
        this.disabled = true;
    });
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?> 