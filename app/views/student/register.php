<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="container">
    <div class="register-card animate__animated animate__fadeInUp">
        <h2 class="mb-4 text-center fw-bold">
            <i class="bi bi-person-plus me-2"></i>Student Registration
        </h2>
        <form id="studentRegisterForm" method="post" action="?controller=student&action=register" enctype="multipart/form-data" autocomplete="off" novalidate>
            <div class="form-floating mb-3 position-relative">
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                <label for="name"><i class="bi bi-person-fill me-2"></i>Name</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                <label for="email"><i class="bi bi-envelope-fill me-2"></i>Email</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                <label for="username"><i class="bi bi-person-badge-fill me-2"></i>Username</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required minlength="6">
                <label for="password"><i class="bi bi-lock-fill me-2"></i>Password</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="text" class="form-control" id="major" name="major" placeholder="Major" required>
                <label for="major"><i class="bi bi-mortarboard-fill me-2"></i>Major</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                <label for="city"><i class="bi bi-geo-alt-fill me-2"></i>City</label>
            </div>
            <div class="mb-3 position-relative">
                <label for="cv" class="form-label text-white">
                    <i class="bi bi-paperclip me-2"></i>Upload CV <span class="text-white-50">(PDF, max 2MB)</span>
                </label>
                <input type="file" class="form-control" id="cv" name="cv" accept="application/pdf" required>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="LinkedIn Profile" required>
                <label for="linkedin"><i class="bi bi-linkedin me-2"></i>LinkedIn Profile</label>
            </div>
            <button type="submit" class="btn btn-glass btn-primary-glass btn-lg w-100 mt-3 animate__animated animate__pulse animate__infinite">
                <i class="bi bi-rocket-takeoff me-2"></i>Register Now
            </button>
        </form>
        <div class="text-center mt-4">
            <a href="?controller=student&action=login" class="text-white text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>Already have an account? <b>Login</b>
            </a>
        </div>
    </div>
</div>

<style>
.form-control {
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid var(--glass-border) !important;
    color: var(--text-light) !important;
    backdrop-filter: blur(10px);
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.15) !important;
    border-color: rgba(255, 255, 255, 0.3) !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1) !important;
    color: var(--text-light) !important;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.6) !important;
}

.form-label {
    color: rgba(255, 255, 255, 0.8) !important;
}

.form-floating > label {
    color: rgba(255, 255, 255, 0.8) !important;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: rgba(255, 255, 255, 0.9) !important;
}
</style>

<script>
// Enhanced client-side validation with glass-morphism feedback
$('#studentRegisterForm').on('submit', function(e) {
    let valid = true;
    let firstError = null;
    
    // Reset all error states
    $('.form-control').removeClass('is-invalid').addClass('is-valid');
    
    // Password validation
    if ($('#password').val().length < 6) {
        valid = false;
        $('#password').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#password');
        showNotification('Password must be at least 6 characters.', 'error');
    }
    
    // CV validation
    if ($('#cv').get(0).files.length === 0) {
        valid = false;
        $('#cv').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#cv');
        showNotification('Please upload your CV (PDF).', 'error');
    } else {
        let file = $('#cv').get(0).files[0];
        if (file.type !== 'application/pdf' || file.size > 2*1024*1024) {
            valid = false;
            $('#cv').removeClass('is-valid').addClass('is-invalid');
            if (!firstError) firstError = $('#cv');
            showNotification('CV must be a PDF file and less than 2MB.', 'error');
        }
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test($('#email').val())) {
        valid = false;
        $('#email').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#email');
        showNotification('Please enter a valid email address.', 'error');
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
        showNotification('Registration successful! Redirecting...', 'success');
    }
});

// Glass-morphism notification system
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

// Add notification styles
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 1rem;
            padding: 1rem 1.5rem;
            color: var(--text-light);
            box-shadow: var(--glass-shadow);
            max-width: 300px;
        }
        .notification-success {
            border-left: 4px solid #10b981;
        }
        .notification-error {
            border-left: 4px solid #ef4444;
        }
        .notification-content {
            display: flex;
            align-items: center;
        }
    `)
    .appendTo('head');
</script>
<?php include __DIR__ . '/../layout/footer.php'; ?> 