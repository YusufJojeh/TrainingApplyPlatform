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

// Get message data
$messageId = $_GET['id'] ?? 0;
$messageModel = new Message($GLOBALS['pdo']);
$message = $messageModel->getById($messageId);

if (!$message || $message['receiver_id'] != $_SESSION['company_id'] || $message['receiver_type'] !== 'company') {
    header('Location: ?controller=company&action=inbox');
    exit;
}

// Get student info
$studentModel = new Student($GLOBALS['pdo']);
$student = $studentModel->getProfile($message['sender_id']);

// Get application info if linked
$application = null;
if ($message['application_id']) {
    $applicationModel = new Application($GLOBALS['pdo']);
    $application = $applicationModel->getById($message['application_id']);
}
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
                        <a href="?controller=company&action=inbox" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-envelope me-2"></i>Back to Inbox
                        </a>
                        <a href="?controller=company&action=dashboard" class="btn btn-glass btn-outline-info">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="col-lg-8">
            <div class="glass-card p-4">
                <!-- Message Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="gradient-text-yellow mb-0">
                        <i class="bi bi-envelope-open me-2"></i>Message Details
                    </h2>
                    <div class="btn-group" role="group">
                        <a href="?controller=company&action=inbox" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>

                <!-- Message Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="glass-card p-3">
                            <h5 class="text-white-50 mb-3">
                                <i class="bi bi-person me-2"></i>From Student
                            </h5>
                            <p class="mb-1"><strong class="text-warning"><?= htmlspecialchars($student['name']) ?></strong></p>
                            <p class="mb-1 text-white-50"><?= htmlspecialchars($student['email']) ?></p>
                            <p class="mb-1 text-white-50"><?= htmlspecialchars($student['major']) ?> • <?= htmlspecialchars($student['city']) ?></p>
                            <?php if ($student['linkedin']): ?>
                                <a href="<?= htmlspecialchars($student['linkedin']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-linkedin me-1"></i>LinkedIn
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="glass-card p-3">
                            <h5 class="text-white-50 mb-3">
                                <i class="bi bi-info-circle me-2"></i>Message Info
                            </h5>
                            <p class="mb-1"><strong class="text-warning">Subject:</strong> <?= htmlspecialchars($message['subject']) ?></p>
                            <p class="mb-1 text-white-50"><strong>Date:</strong> <?= date('M d, Y H:i', strtotime($message['created_at'])) ?></p>
                            <p class="mb-1 text-white-50"><strong>Status:</strong> 
                                <?php if (isset($message['is_read'])): ?>
                                    <span class="badge bg-success">Read</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Unread</span>
                                <?php endif; ?>
                            </p>
                            <?php if ($message['application_id']): ?>
                                <p class="mb-1 text-white-50"><strong>Application:</strong> 
                                    <span class="badge bg-info">#<?= $message['application_id'] ?></span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Application Details (if linked) -->
                <?php if ($application): ?>
                    <div class="mb-4">
                        <div class="glass-card p-3">
                            <h5 class="text-white-50 mb-3">
                                <i class="bi bi-file-earmark-text me-2"></i>Linked Application
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong class="text-warning">Status:</strong> 
                                        <?php
                                        $statusClass = match($application['status']) {
                                            'accepted' => 'success',
                                            'rejected' => 'danger',
                                            default => 'warning'
                                        };
                                        $statusText = ucfirst($application['status']);
                                        ?>
                                        <span class="badge bg-<?= $statusClass ?>"><?= $statusText ?></span>
                                    </p>
                                    <p class="mb-1 text-white-50"><strong>Applied:</strong> <?= date('M d, Y', strtotime($application['created_at'])) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <?php if ($application['comment']): ?>
                                        <p class="mb-1 text-white-50"><strong>Comment:</strong> <?= htmlspecialchars($application['comment']) ?></p>
                                    <?php endif; ?>
                                    <a href="?controller=application&action=detail&id=<?= $application['id'] ?>" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-eye me-1"></i>View Application
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Message Content -->
                <div class="mb-4">
                    <div class="glass-card p-4">
                        <h5 class="text-white-50 mb-3">
                            <i class="bi bi-chat-text me-2"></i>Message Content
                        </h5>
                        <div class="message-content">
                            <?= nl2br(htmlspecialchars($message['content'])) ?>
                        </div>
                    </div>
                </div>

                <!-- Reply Form -->
                <div class="mb-4">
                    <div class="glass-card p-4">
                        <h5 class="text-white-50 mb-3">
                            <i class="bi bi-reply me-2"></i>Reply to Student
                        </h5>
                        <form method="post" action="?controller=company&action=reply" id="replyForm">
                            <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                            <div class="mb-3">
                                <label for="reply_content" class="form-label text-white-50">
                                    <i class="bi bi-chat-dots me-2"></i>Your Reply
                                </label>
                                <textarea class="form-control" id="reply_content" name="reply_content" rows="6" 
                                          placeholder="Type your reply to the student..." required></textarea>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-glass btn-primary-glass btn-lg">
                                    <i class="bi bi-send me-2"></i>Send Reply
                                </button>
                            </div>
                        </form>
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

.form-control::placeholder {
    color: rgba(255, 221, 51, 0.6) !important;
}

.form-label {
    color: rgba(255, 221, 51, 0.8) !important;
    font-weight: 500;
}

.message-content {
    color: var(--accent-yellow);
    line-height: 1.6;
    white-space: pre-wrap;
}

textarea.form-control {
    resize: vertical;
    min-height: 150px;
}

.badge {
    font-size: 0.75rem;
}
</style>

<script>
$('#replyForm').on('submit', function(e) {
    let valid = true;
    let firstError = null;
    
    $('.form-control').removeClass('is-invalid').addClass('is-valid');
    
    // Validate reply content
    if (!$('#reply_content').val().trim()) {
        valid = false;
        $('#reply_content').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#reply_content');
        showNotification('Please enter your reply message.', 'error');
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
        showNotification('Reply sent successfully!', 'success');
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

// Auto-resize textarea
$('#reply_content').on('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?> 