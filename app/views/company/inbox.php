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

// Get messages
$messageModel = new Message($GLOBALS['pdo']);
$messages = $messageModel->getByUser($_SESSION['company_id'], 'company');

// Calculate stats
$totalMessages = count($messages);
$unreadMessages = count(array_filter($messages, function($msg) {
    return $msg['sender_type'] === 'student' && !isset($msg['is_read']);
}));
$studentMessages = array_filter($messages, function($msg) {
    return $msg['sender_type'] === 'student';
});
?>

<div class="container py-5">
    <div class="row">
        <!-- Company Info Card -->
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
                        <a href="?controller=company&action=dashboard" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                        <a href="?controller=company&action=profile" class="btn btn-glass btn-outline-info">
                            <i class="bi bi-building-gear me-2"></i>Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Section -->
        <div class="col-lg-8">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="gradient-text-yellow mb-0">
                        <i class="bi bi-envelope me-2"></i>Message Inbox
                    </h2>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-glass btn-outline-warning active" data-filter="all">All</button>
                        <button type="button" class="btn btn-glass btn-outline-warning" data-filter="unread">Unread</button>
                        <button type="button" class="btn btn-glass btn-outline-warning" data-filter="read">Read</button>
                    </div>
                </div>

                <!-- Message Stats -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="glass-card p-3 text-center">
                            <i class="bi bi-envelope display-4 text-warning mb-2"></i>
                            <h4 class="gradient-text-yellow"><?= $totalMessages ?></h4>
                            <p class="text-white-50 mb-0">Total Messages</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card p-3 text-center">
                            <i class="bi bi-envelope-open display-4 text-warning mb-2"></i>
                            <h4 class="gradient-text-yellow"><?= $unreadMessages ?></h4>
                            <p class="text-white-50 mb-0">Unread</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card p-3 text-center">
                            <i class="bi bi-person display-4 text-warning mb-2"></i>
                            <h4 class="gradient-text-yellow"><?= count($studentMessages) ?></h4>
                            <p class="text-white-50 mb-0">From Students</p>
                        </div>
                    </div>
                </div>

                <?php if (empty($messages)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-white-50 mb-3"></i>
                        <h4 class="text-white-50 mb-3">No Messages Yet</h4>
                        <p class="text-white-50 mb-4">Students will send you messages when they apply for training positions!</p>
                        <a href="?controller=company&action=dashboard" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th>From</th>
                                    <th>Subject</th>
                                    <th>Application</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $message): ?>
                                    <?php if ($message['sender_type'] === 'student'): ?>
                                        <tr data-status="<?= isset($message['is_read']) ? 'read' : 'unread' ?>" 
                                            class="<?= !isset($message['is_read']) ? 'table-warning' : '' ?>">
                                            <td>
                                                <strong class="text-warning"><?= htmlspecialchars($message['sender_name']) ?></strong>
                                                <?php if (!isset($message['is_read'])): ?>
                                                    <span class="badge bg-danger ms-2">New</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-white-50">
                                                <?= htmlspecialchars($message['subject']) ?>
                                            </td>
                                            <td>
                                                <?php if ($message['application_id']): ?>
                                                    <span class="badge bg-info">Application #<?= $message['application_id'] ?></span>
                                                <?php else: ?>
                                                    <span class="text-white-50">General</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-white-50">
                                                <?= date('M d, Y H:i', strtotime($message['created_at'])) ?>
                                            </td>
                                            <td>
                                                <?php if (isset($message['is_read'])): ?>
                                                    <span class="badge bg-success">Read</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Unread</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="?controller=company&action=viewMessage&id=<?= $message['id'] ?>" 
                                                       class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-eye me-1"></i>View
                                                    </a>
                                                    <?php if (!isset($message['is_read'])): ?>
                                                        <a href="?controller=company&action=inbox&mark_read=<?= $message['id'] ?>" 
                                                           class="btn btn-sm btn-outline-success"
                                                           onclick="return confirm('Mark as read?')">
                                                            <i class="bi bi-check me-1"></i>Mark Read
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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

.table-warning {
    background: rgba(255, 193, 7, 0.1) !important;
}

.table-warning:hover {
    background: rgba(255, 193, 7, 0.2) !important;
}

.badge {
    font-size: 0.75rem;
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
            if (filter === 'all') {
                row.style.display = '';
            } else if (filter === 'unread' && row.dataset.status === 'unread') {
                row.style.display = '';
            } else if (filter === 'read' && row.dataset.status === 'read') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});

// Auto-refresh unread count
setInterval(function() {
    // This could be enhanced with AJAX to check for new messages
    const unreadRows = document.querySelectorAll('tbody tr[data-status="unread"]');
    const unreadCount = unreadRows.length;
    
    // Update the unread count display
    const unreadDisplay = document.querySelector('.col-md-4:nth-child(2) h4');
    if (unreadDisplay) {
        unreadDisplay.textContent = unreadCount;
    }
}, 30000); // Check every 30 seconds
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?> 