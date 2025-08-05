<?php
// app/views/layout/header.php - Reusable header with glass-morphism design (yellow/black theme)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practical Training Requests System</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Animate.css CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #232526 0%, #000000 100%);
            --secondary-gradient: linear-gradient(135deg, #ffe259 0%, #ffa751 100%);
            --glass-bg: rgba(255, 221, 51, 0.08);
            --glass-border: rgba(255, 221, 51, 0.18);
            --glass-shadow: 0 8px 32px rgba(255, 221, 51, 0.12);
            --text-light: #fffbe7;
            --text-dark: #232526;
            --accent-yellow: #ffe259;
            --accent-orange: #ffa751;
            --accent-black: #181818;
        }
        body {
            background: var(--primary-gradient);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        .navbar {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: var(--glass-bg) !important;
            border-bottom: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(45deg, var(--accent-yellow), var(--accent-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-link {
            color: var(--accent-yellow) !important;
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem;
            margin: 0 0.25rem;
        }
        .nav-link:hover {
            background: rgba(255, 221, 51, 0.12);
            transform: translateY(-2px);
            color: #fffbe7 !important;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--secondary-gradient);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after {
            width: 80%;
        }
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-gradient);
            color: var(--text-light);
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffe259" stop-opacity="0.12"/><stop offset="100%" stop-color="%23ffe259" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>');
            opacity: 0.25;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            animation: fadeInUp 1.5s cubic-bezier(0.4, 0, 0.2, 1) both;
        }
        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, var(--accent-yellow), var(--accent-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
        }
        .hero-cta {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .btn-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            color: var(--accent-yellow);
            padding: 1rem 2.5rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: var(--glass-shadow);
            position: relative;
            overflow: hidden;
        }
        .btn-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,221,51,0.18), transparent);
            transition: left 0.5s;
        }
        .btn-glass:hover::before {
            left: 100%;
        }
        .btn-glass:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 40px rgba(255, 221, 51, 0.25);
            color: #fffbe7;
        }
        .btn-primary-glass {
            background: var(--secondary-gradient);
            border: none;
            color: var(--accent-black) !important;
        }
        .btn-primary-glass:hover {
            color: #181818 !important;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 221, 51, 0.08);
            backdrop-filter: blur(10px);
            animation: float 12s ease-in-out infinite;
        }
        .shape1 { width: 300px; height: 300px; top: 10%; left: 5%; animation-delay: 0s; }
        .shape2 { width: 200px; height: 200px; bottom: 15%; right: 10%; animation-delay: 4s; }
        .shape3 { width: 150px; height: 150px; top: 60%; left: 80%; animation-delay: 8s; }
        .shape4 { width: 100px; height: 100px; top: 20%; right: 20%; animation-delay: 2s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(120deg); }
            66% { transform: translateY(-15px) rotate(240deg); }
        }
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            box-shadow: var(--glass-shadow);
            padding: 2rem;
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(255, 221, 51, 0.25);
        }
        .register-card {
            max-width: 550px;
            margin: 3rem auto;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 2rem;
            box-shadow: var(--glass-shadow);
            padding: 3rem 2.5rem;
            animation: fadeInUp 1.2s cubic-bezier(0.4, 0, 0.2, 1) both;
        }
        .register-card h2 {
            color: var(--accent-yellow);
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-floating > .form-control {
            background: rgba(255, 221, 51, 0.08);
            border: 1px solid var(--glass-border);
            color: var(--accent-yellow);
            backdrop-filter: blur(10px);
        }
        .form-floating > .form-control:focus {
            background: rgba(255, 221, 51, 0.15);
            border-color: rgba(255, 221, 51, 0.3);
            box-shadow: 0 0 0 0.2rem rgba(255, 221, 51, 0.1);
            color: var(--accent-yellow);
        }
        .form-floating > .form-control::placeholder {
            color: rgba(255, 221, 51, 0.7);
        }
        .form-floating > label {
            color: rgba(255, 221, 51, 0.8);
        }
        .form-control {
            color: var(--accent-yellow);
        }
        .form-control::placeholder {
            color: rgba(255, 221, 51, 0.6);
        }
        .section {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .section.visible {
            opacity: 1;
            transform: translateY(0);
        }
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .hero p { font-size: 1.1rem; }
            .hero-cta { flex-direction: column; align-items: center; }
            .btn-glass { width: 100%; max-width: 300px; }
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(255, 221, 51, 0.08);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--secondary-gradient);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-gradient);
        }
    </style>
</head>
<body>
<?php if (isset($_SESSION['admin_id'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="?controller=admin&action=dashboard">
            <i class="bi bi-shield-lock me-2"></i>Admin Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?controller=admin&action=dashboard"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=admin&action=students"><i class="bi bi-people me-1"></i>Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=admin&action=companies"><i class="bi bi-building me-1"></i>Companies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=admin&action=applications"><i class="bi bi-file-earmark-text me-1"></i>Applications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=admin&action=logs"><i class="bi bi-list-check me-1"></i>Logs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="?controller=admin&action=logout"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php elseif (isset($_SESSION['student_id'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="?controller=student&action=dashboard">
            <i class="bi bi-person-workspace me-2"></i>Student Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStudent" aria-controls="navbarStudent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarStudent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?controller=student&action=dashboard"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=student&action=profile"><i class="bi bi-person-circle me-1"></i>Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=student&action=settings"><i class="bi bi-gear me-1"></i>Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=student&action=composeMessage"><i class="bi bi-envelope-plus me-1"></i>Compose</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="?controller=student&action=logout"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php elseif (isset($_SESSION['company_id'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="?controller=company&action=dashboard">
            <i class="bi bi-building me-2"></i>Company Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCompany" aria-controls="navbarCompany" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCompany">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?controller=company&action=dashboard"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=company&action=profile"><i class="bi bi-building-gear me-1"></i>Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=company&action=settings"><i class="bi bi-gear me-1"></i>Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=company&action=inbox"><i class="bi bi-envelope me-1"></i>Inbox</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=company&action=composeMessage"><i class="bi bi-envelope-plus me-1"></i>Compose</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="?controller=company&action=logout"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php else: ?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="?controller=home">
            <i class="bi bi-rocket-takeoff me-2"></i>Training System
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?controller=student&action=register">
                        <i class="bi bi-person-plus me-1"></i>Student Register
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=company&action=register">
                        <i class="bi bi-building-add me-1"></i>Company Register
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=auth&action=login">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?> 