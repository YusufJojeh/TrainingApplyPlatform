<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="container">
    <div class="register-card animate__animated animate__fadeInUp">
        <h2 class="mb-4 text-center fw-bold">
            <i class="bi bi-shield-lock me-2"></i>Unified Login
        </h2>
        <form id="unifiedLoginForm" method="post" action="?controller=auth&action=login" autocomplete="off" novalidate>
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            
            <!-- Role Selector -->
            <div class="form-floating mb-3 position-relative">
                <select class="form-control" id="role" name="role" required>
                    <option value="">Select your role</option>
                    <option value="student">Student</option>
                    <option value="company">Company</option>
                    <option value="admin">Admin</option>
                </select>
                <label for="role"><i class="bi bi-person-badge me-2"></i>Select Role</label>
            </div>
            
            <!-- Username/Email Field -->
            <div class="form-floating mb-3 position-relative">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username or Email" required>
                <label for="username"><i class="bi bi-person-badge-fill me-2"></i>Username or Email</label>
            </div>
            
            <!-- Password Field -->
            <div class="form-floating mb-3 position-relative">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password"><i class="bi bi-lock-fill me-2"></i>Password</label>
            </div>
            
            <!-- Error Display -->
            <?php if (!empty($error)): ?>
            <div class="alert alert-danger animate__animated animate__shakeX" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <!-- Submit Button -->
            <button type="submit" class="btn btn-glass btn-primary-glass btn-lg w-100 mt-3 animate__animated animate__pulse animate__infinite">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </button>
        </form>
        
        <!-- Registration Links -->
        <div class="text-center mt-4">
            <div class="row">
                <div class="col-md-6">
                    <a href="?controller=student&action=register" class="text-white text-decoration-none">
                        <i class="bi bi-person-plus me-1"></i>Student Register
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="?controller=company&action=register" class="text-white text-decoration-none">
                        <i class="bi bi-building-add me-1"></i>Company Register
                    </a>
                </div>
            </div>
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

/* Select dropdown styling */
select.form-control option {
    background: var(--accent-black);
    color: var(--accent-yellow);
}

.alert-danger {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #fca5a5;
    backdrop-filter: blur(10px);
}

.alert-danger i {
    color: #fca5a5;
}
</style>

<script>
$('#unifiedLoginForm').on('submit', function(e) {
    let valid = true;
    let firstError = null;
    
    // Reset validation states
    $('.form-control').removeClass('is-invalid').addClass('is-valid');
    
    // Validate role selection
    if (!$('#role').val()) {
        valid = false;
        $('#role').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#role');
        showNotification('Please select your role.', 'error');
    }
    
    // Validate username
    if (!$('#username').val()) {
        valid = false;
        $('#username').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#username');
        showNotification('Please enter your username or email.', 'error');
    }
    
    // Validate password
    if ($('#password').val().length < 6) {
        valid = false;
        $('#password').removeClass('is-valid').addClass('is-invalid');
        if (!firstError) firstError = $('#password');
        showNotification('Password must be at least 6 characters.', 'error');
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
        showNotification('Login successful! Redirecting...', 'success');
    }
});

// Role-based visual feedback
$('#role').on('change', function() {
    const role = $(this).val();
    const icon = $('h2 i');
    const title = $('h2');
    
    switch(role) {
        case 'student':
            icon.removeClass().addClass('bi bi-person-check me-2');
            title.html('<i class="bi bi-person-check me-2"></i>Student Login');
            break;
        case 'company':
            icon.removeClass().addClass('bi bi-building-check me-2');
            title.html('<i class="bi bi-building-check me-2"></i>Company Login');
            break;
        case 'admin':
            icon.removeClass().addClass('bi bi-shield-lock me-2');
            title.html('<i class="bi bi-shield-lock me-2"></i>Admin Login');
            break;
        default:
            icon.removeClass().addClass('bi bi-shield-lock me-2');
            title.html('<i class="bi bi-shield-lock me-2"></i>Unified Login');
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