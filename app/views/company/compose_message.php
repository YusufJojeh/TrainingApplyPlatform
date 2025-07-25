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

// Get students for dropdown
$studentModel = new Student($GLOBALS['pdo']);
$students = $studentModel->getAll();

// Get applications for linking
$applicationModel = new Application($GLOBALS['pdo']);
$applications = $applicationModel->getByCompany($_SESSION['company_id']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient_id = $_POST['recipient_id'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $content = $_POST['content'] ?? '';
    $application_id = $_POST['application_id'] ?? null;

    if (empty($recipient_id) || empty($subject) || empty($content)) {
        $error = 'Please fill in all required fields.';
    } else {
        $messageModel = new Message($GLOBALS['pdo']);
        $messageData = [
            'sender_id' => $_SESSION['company_id'],
            'sender_type' => 'company',
            'recipient_id' => $recipient_id,
            'recipient_type' => 'student',
            'subject' => $subject,
            'content' => $content,
            'application_id' => $application_id
        ];

        if ($messageModel->create($messageData)) {
            $success = 'Message sent successfully!';
            $_POST = [];
        } else {
            $error = 'Failed to send message. Please try again.';
        }
    }
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
                        <a href="?controller=company&action=dashboard" class="btn btn-glass btn-outline-warning">
                            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                        </a>
                        <a href="?controller=company&action=inbox" class="btn btn-glass btn-outline-info">
                            <i class="bi bi-envelope me-2"></i>View Inbox
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Compose Message Form -->
        <div class="col-lg-8">
            <div class="glass-card p-4">
                <h2 class="gradient-text-yellow mb-4">
                    <i class="bi bi-envelope-plus me-2"></i>Compose Message
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

                <form method="post" action="?controller=company&action=composeMessage" id="composeForm" autocomplete="off">
                    <!-- Recipient Selection -->
                    <div class="mb-4">
                        <label for="recipient_id" class="form-label text-white-50">
                            <i class="bi bi-person me-2"></i>To Student *
                        </label>
                        <select class="form-control" id="recipient_id" name="recipient_id" required>
                            <option value="">Select a student...</option>
                            <?php foreach ($students as $student): ?>
                                <option value="<?= $student['id'] ?>" <?= (isset($_POST['recipient_id']) && $_POST['recipient_id'] == $student['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($student['name']) ?> - <?= htmlspecialchars($student['major']) ?> (<?= htmlspecialchars($student['city']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Subject -->
                    <div class="mb-4">
                        <label for="subject" class="form-label text-white-50">
                            <i class="bi bi-tag me-2"></i>Subject *
                        </label>
                        <input type="text" class="form-control" id="subject" name="subject"
                               value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>"
                               placeholder="Enter message subject..." required>
                    </div>

                    <!-- Link to Application (Optional) -->
                    <?php if (!empty($applications)): ?>
                        <div class="mb-4">
                            <label for="application_id" class="form-label text-white-50">
                                <i class="bi bi-link me-2"></i>Link to Application (Optional)
                            </label>
                            <select class="form-control" id="application_id" name="application_id">
                                <option value="">No application linked</option>
                                <?php foreach ($applications as $app): ?>
                                    <option value="<?= $app['id'] ?>" <?= (isset($_POST['application_id']) && $_POST['application_id'] == $app['id']) ? 'selected' : '' ?>>
                                        Application #<?= $app['id'] ?> - <?= htmlspecialchars($app['student_name']) ?> (<?= ucfirst($app['status']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-white-50">Linking to an application helps students understand the context of your message.</div>
                        </div>
                    <?php endif; ?>

                    <!-- Message Content -->
                    <div class="mb-4">
                        <label for="content" class="form-label text-white-50">
                            <i class="bi bi-chat-text me-2"></i>Message Content *
                        </label>
                        <textarea id="compose-textarea" class="form-control" name="content" required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
                        <div class="form-text text-white-50">
                            <i class="bi bi-info-circle me-1"></i>
                            Be professional and clear in your message. Provide helpful information about opportunities or feedback.
                        </div>
                    </div>

                    <!-- Message Templates -->
                    <div class="mb-4">
                        <label class="form-label text-white-50">
                            <i class="bi bi-lightning me-2"></i>Quick Templates
                        </label>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-glass btn-outline-warning btn-sm" data-template="approve">
                                <i class="bi bi-check-circle me-1"></i>Approve
                            </button>
                            <button type="button" class="btn btn-glass btn-outline-warning btn-sm" data-template="reject">
                                <i class="bi bi-x-circle me-1"></i>Reject
                            </button>
                            <button type="button" class="btn btn-glass btn-outline-warning btn-sm" data-template="information">
                                <i class="bi bi-info-circle me-1"></i>Information
                            </button>
                            <button type="button" class="btn btn-glass btn-outline-warning btn-sm" data-template="general">
                                <i class="bi bi-chat-dots me-1"></i>General
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-glass btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-glass btn-primary-glass btn-lg">
                            <i class="bi bi-send me-2"></i>Send Message
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
    min-height: 300px;
}
.btn-group .btn {
    margin-right: 0.25rem;
}
.btn-group .btn:last-child {
    margin-right: 0;
}
</style>

<!-- jQuery (CDN with local fallback) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>window.jQuery || document.write('<script src="/pro/public/assets/js/jquery.min.js"><\/script>');</script>
<!-- Bootstrap Bundle (CDN with local fallback) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
if (typeof bootstrap === 'undefined') {
  document.write('<script src="/pro/public/assets/js/bootstrap.bundle.min.js"><\/script>');
}
</script>
<!-- Summernote CSS/JS (CDN with local fallback) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet" onerror="this.href='/pro/public/assets/summernote/summernote-bs4.min.css'">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
<script>
if (typeof $.fn.summernote === 'undefined') {
  document.write('<script src="/pro/public/assets/summernote/summernote.min.js"><\/script>');
  document.write('<script src="/pro/public/assets/summernote/summernote-bs4.min.js"><\/script>');
}
</script>

<script>
$(function () {
    // Quick template logic (plain text)
    const templates = {
        approve: {
            subject: 'Your Application Has Been Approved',
            content: `Dear [Student Name],\n\nCongratulations! We are pleased to inform you that your application for training at [Company Name] has been approved.\n\nWe look forward to welcoming you to our team. Please reply to this message to confirm your acceptance and let us know if you have any questions.\n\nBest regards,\n[Your Name]\n[Company Name]`
        },
        reject: {
            subject: 'Update on Your Application',
            content: `Dear [Student Name],\n\nThank you for your interest in training at [Company Name]. After careful consideration, we regret to inform you that we are unable to offer you a position at this time.\n\nWe appreciate your effort and encourage you to apply again in the future.\n\nBest wishes for your continued success.\n\nBest regards,\n[Your Name]\n[Company Name]`
        },
        information: {
            subject: 'Information About Training Opportunities',
            content: `Dear [Student Name],\n\nThank you for your inquiry about training opportunities at [Company Name].\n\nHere is some information about our current programs:\n- Duration: [X] months\n- Requirements: [List requirements]\n- Application process: [Describe process]\n\nIf you have further questions, feel free to ask.\n\nBest regards,\n[Your Name]\n[Company Name]`
        },
        general: {
            subject: 'General Message from [Company Name]',
            content: `Dear [Student Name],\n\nWe wanted to reach out to you regarding [subject].\n\n[Write your message here]\n\nIf you have any questions, please let us know.\n\nBest regards,\n[Your Name]\n[Company Name]`
        }
    };

    $('[data-template]').on('click', function() {
        const type = $(this).data('template');
        if (templates[type]) {
            $('#subject').val(templates[type].subject);
            $('#compose-textarea').val(templates[type].content);
            showNotification('Template loaded! Please customize the content.', 'success');
        }
    });

    // Form validation
    $('#composeForm').on('submit', function(e) {
        let valid = true;
        let firstError = null;

        $('.form-control').removeClass('is-invalid').addClass('is-valid');

        if (!$('#recipient_id').val()) {
            valid = false;
            $('#recipient_id').removeClass('is-valid').addClass('is-invalid');
            if (!firstError) firstError = $('#recipient_id');
            showNotification('Please select a recipient.', 'error');
        }
        if (!$('#subject').val().trim()) {
            valid = false;
            $('#subject').removeClass('is-valid').addClass('is-invalid');
            if (!firstError) firstError = $('#subject');
            showNotification('Please enter a subject for your message.', 'error');
        }
        if (!$('#compose-textarea').val().trim()) {
            valid = false;
            $('#compose-textarea').removeClass('is-valid').addClass('is-invalid');
            if (!firstError) firstError = $('#compose-textarea');
            showNotification('Please enter your message content.', 'error');
        }

        if (!valid) {
            e.preventDefault();
            if (firstError) {
                firstError.focus();
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
            }
        }
    });

    // Notification helper
    function showNotification(message, type) {
        const notification = $(
            `<div class="notification notification-${type} animate__animated animate__fadeInRight" style="position:fixed;top:20px;right:20px;z-index:9999;">
                <div class="notification-content p-3 bg-${type === 'success' ? 'success' : 'danger'} text-white rounded shadow">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                    ${message}
                </div>
            </div>`
        );
        $('body').append(notification);
        setTimeout(() => {
            notification.fadeOut(500, () => notification.remove());
        }, 2500);
    }
});
</script>
<?php include __DIR__ . '/../layout/footer.php'; ?> 