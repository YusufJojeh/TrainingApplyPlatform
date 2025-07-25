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
?>

<div class="container py-5">
    <div class="row">
        <!-- Company Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="glass-card p-4 h-100">
                <div class="text-center mb-4">
                    <div class="profile-avatar mb-3">
                        <i class="bi bi-building display-1 text-warning"></i>
                    </div>
                    <h3 class="gradient-text-yellow mb-2"><?= htmlspecialchars($company['name']) ?></h3>
                    <p class="text-white-50 mb-1"><?= htmlspecialchars($company['field']) ?></p>
                    <p class="text-white-50 mb-3"><?= htmlspecialchars($company['city']) ?></p>
                    <div class="d-grid gap-2">
                        <a href="?controller=company&action=profile" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-building-gear me-2"></i>Profile
                        </a>
                        <a href="?controller=company&action=settings" class="btn btn-glass btn-outline-info">
                            <i class="bi bi-gear me-2"></i>Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applications Section -->
        <div class="col-lg-8">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="gradient-text-yellow mb-0">Received Applications</h2>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-glass btn-outline-warning active" data-filter="all">All</button>
                        <button type="button" class="btn btn-glass btn-outline-warning" data-filter="pending">Pending</button>
                        <button type="button" class="btn btn-glass btn-outline-warning" data-filter="accepted">Accepted</button>
                        <button type="button" class="btn btn-glass btn-outline-warning" data-filter="rejected">Rejected</button>
                        <a href="?controller=company&action=inbox" class="btn btn-glass btn-outline-warning ms-2">
                            <i class="bi bi-envelope me-2"></i>Inbox
                        </a>
                        <a href="?controller=company&action=composeMessage" class="btn btn-glass btn-outline-info ms-2">
                            <i class="bi bi-envelope-plus me-2"></i>Compose
                        </a>
                    </div>
                </div>

                <?php if (empty($applications)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-white-50 mb-3"></i>
                        <h4 class="text-white-50 mb-3">No Applications Yet</h4>
                        <p class="text-white-50 mb-4">Students will be able to apply to your company once you're fully set up!</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Major</th>
                                    <th>Status</th>
                                    <th>Applied Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applications as $app): ?>
                                    <tr data-status="<?= $app['status'] ?>">
                                        <td>
                                            <strong class="text-warning"><?= htmlspecialchars($app['student_name']) ?></strong>
                                        </td>
                                        <td class="text-white-50">
                                            <?= htmlspecialchars($app['major'] ?? 'N/A') ?>
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
                                        <td class="text-white-50">
                                            <?= date('M d, Y', strtotime($app['created_at'])) ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="?controller=application&action=detail&id=<?= $app['id'] ?>" 
                                                   class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
                                                <?php if ($app['status'] === 'pending'): ?>
                                                    <a href="?controller=application&action=update&id=<?= $app['id'] ?>&status=accepted" 
                                                       class="btn btn-sm btn-outline-success"
                                                       onclick="return confirm('Accept this application?')">
                                                        <i class="bi bi-check me-1"></i>Accept
                                                    </a>
                                                    <a href="?controller=application&action=update&id=<?= $app['id'] ?>&status=rejected" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Reject this application?')">
                                                        <i class="bi bi-x me-1"></i>Reject
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
    </div>

    <!-- Quick Stats -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="glass-card p-3 text-center">
                <i class="bi bi-file-earmark-text display-4 text-warning mb-2"></i>
                <h4 class="gradient-text-yellow"><?= count($applications) ?></h4>
                <p class="text-white-50 mb-0">Total Applications</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card p-3 text-center">
                <i class="bi bi-clock display-4 text-warning mb-2"></i>
                <h4 class="gradient-text-yellow">
                    <?= count(array_filter($applications, fn($app) => $app['status'] === 'pending')) ?>
                </h4>
                <p class="text-white-50 mb-0">Pending</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card p-3 text-center">
                <i class="bi bi-check-circle display-4 text-success mb-2"></i>
                <h4 class="gradient-text-yellow">
                    <?= count(array_filter($applications, fn($app) => $app['status'] === 'accepted')) ?>
                </h4>
                <p class="text-white-50 mb-0">Accepted</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card p-3 text-center">
                <i class="bi bi-x-circle display-4 text-danger mb-2"></i>
                <h4 class="gradient-text-yellow">
                    <?= count(array_filter($applications, fn($app) => $app['status'] === 'rejected')) ?>
                </h4>
                <p class="text-white-50 mb-0">Rejected</p>
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
</style>

<script>
// Filter functionality
document.querySelectorAll('[data-filter]').forEach(button => {
    button.addEventListener('click', function() {
        const filter = this.dataset.filter;
        
        // Update active button
        document.querySelectorAll('[data-filter]').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        
        // Filter table rows
        document.querySelectorAll('tbody tr').forEach(row => {
            if (filter === 'all' || row.dataset.status === filter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?> 