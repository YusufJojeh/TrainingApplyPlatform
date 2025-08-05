<?php include __DIR__ . '/../layout/header.php'; ?>
<?php
// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: ?controller=student&action=login');
    exit;
}

// Get student data
$studentModel = new Student($GLOBALS['pdo']);
$student = $studentModel->getProfile($_SESSION['student_id']);

// Get companies for dropdown
$companyModel = new Company($GLOBALS['pdo']);
$companies = $companyModel->getAll();

// Get applications for linking
$applicationModel = new Application($GLOBALS['pdo']);
$applications = $applicationModel->getByStudent($_SESSION['student_id']);

// Pre-fill subject/content if set in session (from application create)
$prefill_subject = $_SESSION['compose_subject'] ?? '';
$prefill_content = $_SESSION['compose_content'] ?? '';
unset($_SESSION['compose_subject'], $_SESSION['compose_content']);
$prefill_company = $_GET['company_id'] ?? '';
$prefill_application = $_GET['application_id'] ?? '';

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
            'sender_id' => $_SESSION['student_id'],
            'sender_type' => 'student',
            'recipient_id' => $recipient_id,
            'recipient_type' => 'company',
            'subject' => $subject,
            'content' => $content,
            'application_id' => $application_id
        ];
        
        if ($messageModel->create($messageData)) {
            $success = 'Message sent successfully!';
            // Clear form
            $_POST = [];
        } else {
            $error = 'Failed to send message. Please try again.';
        }
    }
}
?>

<div class="main-content">
    <div class="container py-5">
        <div class="row">
            <!-- Student Info Card -->
            <div class="col-lg-4 mb-4">
                <div class="glass-card p-4 h-100 animate__animated animate__fadeInUp">
                    <div class="text-center mb-4">
                        <div class="profile-avatar mb-3">
                            <?php if (!empty($student['cv'])): ?>
                                <i class="bi bi-file-earmark-person display-1 text-warning"></i>
                            <?php else: ?>
                                <i class="bi bi-person display-1 text-warning"></i>
                            <?php endif; ?>
                        </div>
                        <h3 class="gradient-text-yellow mb-2"><?= htmlspecialchars($student['name']) ?></h3>
                        <p class="text-white-50 mb-1"><?= htmlspecialchars($student['major']) ?></p>
                        <p class="text-white-50 mb-3"><?= htmlspecialchars($student['city']) ?></p>
                        <div class="d-grid gap-2">
                            <a href="?controller=student&action=dashboard" class="btn btn-glass btn-outline-warning">
                                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                            </a>
                            <a href="?controller=message&action=inbox" class="btn btn-glass btn-outline-info">
                                <i class="bi bi-envelope me-2"></i>View Messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compose Message Form -->
            <div class="col-lg-8">
                <div class="glass-card p-4 animate__animated animate__fadeInUp animate__delay-1s">
                    <h2 class="gradient-text-yellow mb-4">
                        <i class="bi bi-envelope-plus me-2"></i>Compose Message
                    </h2>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInUp" role="alert">
                            <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInUp" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="?controller=student&action=composeMessage" id="composeForm">
                        <!-- Recipient Selection -->
                        <div class="mb-4">
                            <label for="recipient_id" class="form-label text-white-50">
                                <i class="bi bi-building me-2"></i>To Company *
                            </label>
                            <select class="form-control" id="recipient_id" name="recipient_id" required>
                                <option value="">Select a company...</option>
                                <?php foreach ($companies as $company): ?>
                                    <option value="<?= $company['id'] ?>" <?= ($prefill_company && $prefill_company == $company['id']) ? 'selected' : ((isset($_POST['recipient_id']) && $_POST['recipient_id'] == $company['id']) ? 'selected' : '') ?>>
                                        <?= htmlspecialchars($company['name']) ?> - <?= htmlspecialchars($company['field']) ?> (<?= htmlspecialchars($company['city']) ?>)
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
                                   value="<?= htmlspecialchars($prefill_subject ?: ($_POST['subject'] ?? '')) ?>" 
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
                                        <option value="<?= $app['id'] ?>" <?= ($prefill_application && $prefill_application == $app['id']) ? 'selected' : ((isset($_POST['application_id']) && $_POST['application_id'] == $app['id']) ? 'selected' : '') ?>>
                                            Application #<?= $app['id'] ?> - <?= htmlspecialchars($app['company_name']) ?> (<?= ucfirst($app['status']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text text-white-50">Linking to an application helps companies understand the context of your message.</div>
                            </div>
                        <?php endif; ?>

                        <!-- Message Content -->
                        <div class="mb-4">
                            <label for="content" class="form-label text-white-50">
                                <i class="bi bi-chat-text me-2"></i>Message Content *
                            </label>
                            <textarea id="compose-textarea" class="form-control" name="content" style="height: 300px" required><?= htmlspecialchars($prefill_content ?: ($_POST['content'] ?? '')) ?></textarea>
                            <div class="form-text text-white-50">
                                <i class="bi bi-info-circle me-1"></i>
                                Be professional and clear in your message. Include relevant details about your interest in the company.
                            </div>
                        </div>

                        <!-- Message Templates -->
                        <div class="mb-4">
                            <label class="form-label text-white-50">
                                <i class="bi bi-lightning me-2"></i>Quick Templates
                            </label>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-glass btn-outline-warning btn-sm" onclick="loadTemplate('inquiry')">
                                    <i class="bi bi-question-circle me-1"></i>General Inquiry
                                </button>
                                <button type="button" class="btn btn-glass btn-outline-warning btn-sm" onclick="loadTemplate('application')">
                                    <i class="bi bi-file-earmark-text me-1"></i>Application Follow-up
                                </button>
                                <button type="button" class="btn btn-glass btn-outline-warning btn-sm" onclick="loadTemplate('thank')">
                                    <i class="bi bi-heart me-1"></i>Thank You
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
</div>

<script>
// Message templates
const templates = {
    inquiry: {
        subject: 'General Inquiry About Training Opportunities',
        content: `Dear [Company Name],\n\nI hope this message finds you well. I am a student at [Your University] studying [Your Major], and I am very interested in learning more about training opportunities at your company.\n\nI am particularly drawn to [Company Name] because of your reputation in [Field/Industry] and your commitment to [specific aspect that interests you].\n\nI would greatly appreciate if you could provide me with more information about:\n- Available training positions\n- Application requirements\n- Training duration and structure\n- Any upcoming opportunities\n\nI have attached my CV and would be happy to provide any additional information you may need.\n\nThank you for considering my inquiry. I look forward to hearing from you.\n\nBest regards,\n[Your Name]\n[Your Contact Information]`
    },
    application: {
        subject: 'Follow-up on My Training Application',
        content: `Dear [Company Name],\n\nI hope this message finds you well. I am writing to follow up on my training application that I submitted on [Date].\n\nI wanted to express my continued interest in the training opportunity at [Company Name] and inquire about the current status of my application.\n\nI understand that you receive many applications and appreciate the time you take to review each one carefully. I remain very enthusiastic about the possibility of joining your team and contributing to [Company Name]'s success.\n\nIf there is any additional information or documentation you need from me, please don't hesitate to ask. I am also available for any interviews or further discussions at your convenience.\n\nThank you for considering my application. I look forward to hearing from you.\n\nBest regards,\n[Your Name]\n[Your Contact Information]`
    },
    thank: {
        subject: 'Thank You for the Opportunity',
        content: `Dear [Company Name],\n\nI hope this message finds you well. I wanted to take a moment to express my sincere gratitude for the opportunity to [apply for training/participate in the interview process] at [Company Name].\n\nI truly appreciate the time and consideration you have given to my application. The experience has been valuable, and I have learned a great deal about [Company Name] and the industry.\n\nWhether or not I am selected for this opportunity, I am grateful for the chance to connect with your team and learn more about your organization. I will continue to follow [Company Name]'s work and achievements with great interest.\n\nThank you again for this opportunity. I wish you and your team continued success.\n\nBest regards,\n[Your Name]\n[Your Contact Information]`
    }
};

function loadTemplate(type) {
    if (templates[type]) {
        document.getElementById('subject').value = templates[type].subject;
        document.getElementById('compose-textarea').value = templates[type].content;
        showNotification('Template loaded! Please customize the content.', 'success');
    }
}

$('#composeForm').on('submit', function(e) {
    let valid = true;
    let firstError = null;
    
    $('.form-control').removeClass('is-invalid').addClass('is-valid');
    
    // Validate required fields
    if (!$('#recipient_id').val()) {
        valid = false;
        $('#recipient_id').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#recipient_id');
        showNotification('Please select a recipient company.', 'error');
    }
    
    if (!$('#subject').val().trim()) {
        valid = false;
        $('#subject').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#subject');
        showNotification('Please enter a subject for your message.', 'error');
    }
    
    if (!$('#compose-textarea').val().trim()) {
        valid = false;
        $('#compose-textarea').focus();
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
    } else {
        showNotification('Message sent successfully!', 'success');
    }
});

// Auto-resize textarea
$('#compose-textarea').on('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
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
        notification.fadeOut(500, () => notification.remove());
    }, 3000);
}

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