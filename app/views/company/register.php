<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="container">
    <div class="register-card animate__animated animate__fadeInUp">
        <h2 class="mb-4 text-center fw-bold">
            <i class="bi bi-building-add me-2"></i>Company Registration
        </h2>
        <form id="companyRegisterForm" method="post" action="?controller=company&action=register" enctype="multipart/form-data" autocomplete="off" novalidate>
            <div class="form-floating mb-3 position-relative">
                <input type="text" class="form-control" id="name" name="name" placeholder="Company Name" required>
                <label for="name"><i class="bi bi-building me-2"></i>Company Name</label>
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
                <input type="text" class="form-control" id="field" name="field" placeholder="Field" required>
                <label for="field"><i class="bi bi-briefcase-fill me-2"></i>Field</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                <label for="city"><i class="bi bi-geo-alt-fill me-2"></i>City</label>
            </div>
            <div class="mb-3 position-relative">
                <label for="description" class="form-label text-white">
                    <i class="bi bi-card-text me-2"></i>Description
                </label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe your company"></textarea>
            </div>
            <button type="submit" class="btn btn-glass btn-primary-glass btn-lg w-100 mt-3 animate__animated animate__pulse animate__infinite">
                <i class="bi bi-rocket-takeoff me-2"></i>Register Company
            </button>
        </form>
        <div class="text-center mt-4">
            <a href="?controller=company&action=login" class="text-white text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>Already have an account? <b>Login</b>
            </a>
        </div>
    </div>
</div>
<style>
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
}
.form-floating > label {
    color: rgba(255, 221, 51, 0.8) !important;
}
.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: rgba(255, 221, 51, 0.9) !important;
}
</style>
<script>
$('#companyRegisterForm').on('submit', function(e) {
    let valid = true;
    let firstError = null;
    $('.form-control').removeClass('is-invalid').addClass('is-valid');
    if ($('#password').val().length < 6) {
        valid = false;
        $('#password').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#password');
        showNotification('Password must be at least 6 characters.', 'error');
    }
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
            color: var(--accent-yellow);
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