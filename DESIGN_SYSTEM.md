# Unified Design System for Training System

## Overview

This document outlines the unified design system implemented across the Training System PHP MVC project, based on the landing page design patterns for consistency and modern user experience.

## Design Philosophy

### Core Principles
- **Glassmorphism**: Modern glass-like effects with blur and transparency
- **Yellow/Black Theme**: Consistent color palette with yellow accents on dark backgrounds
- **Responsive Design**: Mobile-first approach with Bootstrap 5
- **Smooth Animations**: Subtle transitions and hover effects
- **Accessibility**: High contrast and readable typography

## Color Palette

### Primary Colors
```css
--primary-gradient: linear-gradient(135deg, #232526 0%, #000000 100%);
--secondary-gradient: linear-gradient(135deg, #ffe259 0%, #ffa751 100%);
--accent-yellow: #ffe259;
--accent-orange: #ffa751;
--accent-black: #181818;
```

### Glass Effects
```css
--glass-bg: rgba(255, 221, 51, 0.08);
--glass-border: rgba(255, 221, 51, 0.18);
--glass-shadow: 0 8px 32px rgba(255, 221, 51, 0.12);
--liquid-bg: rgba(10, 10, 10, 0.7);
--liquid-border: rgba(255, 255, 255, 0.18);
```

### Status Colors
```css
--success-color: #10b981;
--error-color: #ef4444;
--warning-color: #f59e0b;
--info-color: #3b82f6;
```

## Typography

### Font Stack
```css
font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
```

### Text Classes
- `.gradient-text-yellow`: Yellow gradient text effect
- `.text-white-50`: Semi-transparent white text
- `.text-warning`: Yellow accent text

## Component Library

### 1. Buttons

#### Primary Glass Button
```html
<a href="#" class="btn btn-glass btn-primary-glass">
    <i class="bi bi-person-plus me-2"></i>Get Started
</a>
```

#### Outline Buttons
```html
<a href="#" class="btn btn-glass btn-outline-warning">View</a>
<a href="#" class="btn btn-glass btn-outline-secondary">Edit</a>
<a href="#" class="btn btn-glass btn-outline-danger">Delete</a>
```

### 2. Cards

#### Glass Card
```html
<div class="glass-card p-4">
    <h3 class="gradient-text-yellow">Card Title</h3>
    <p class="text-white-50">Card content</p>
</div>
```

#### Register Card
```html
<div class="register-card">
    <h2 class="gradient-text-yellow">Login</h2>
    <!-- Form content -->
</div>
```

### 3. Forms

#### Form Controls
```html
<div class="form-floating mb-3">
    <input type="text" class="form-control" id="username" name="username" required>
    <label for="username">Username</label>
</div>
```

#### Form Select
```html
<select class="form-select" name="status" required>
    <option value="">Choose...</option>
    <option value="pending">Pending</option>
</select>
```

### 4. Tables

#### Dark Table
```html
<table class="table table-dark align-middle glass-card">
    <thead>
        <tr>
            <th class="text-white">Header</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-white">Data</td>
        </tr>
    </tbody>
</table>
```

### 5. Badges

#### Status Badges
```html
<span class="badge bg-success text-white fw-bold">Accepted</span>
<span class="badge bg-warning text-dark fw-bold">Pending</span>
<span class="badge bg-danger text-white fw-bold">Rejected</span>
```

### 6. Modals

#### Glass Modal
```html
<div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card">
            <div class="modal-header border-0">
                <h5 class="modal-title gradient-text-yellow">Modal Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-white-50">
                Modal content
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-glass">Save</button>
            </div>
        </div>
    </div>
</div>
```

## Layout Structure

### Main Content Wrapper
```html
<div class="main-content">
    <div class="container py-5">
        <!-- Page content -->
    </div>
</div>
```

### Section Layout
```html
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="glass-card p-4">
                    <!-- Section content -->
                </div>
            </div>
        </div>
    </div>
</section>
```

## Page Templates

### 1. Login/Register Pages
```php
<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="container">
    <div class="register-card animate__animated animate__fadeInUp">
        <h2 class="mb-4 text-center fw-bold gradient-text-yellow">
            <i class="bi bi-person-check me-2"></i>Login
        </h2>
        <form method="post">
            <!-- Form fields -->
        </form>
    </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
```

### 2. Dashboard Pages
```php
<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="main-content">
    <div class="container py-5">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="glass-card p-3 text-center">
                    <h3 class="gradient-text-yellow"><?= $count ?></h3>
                    <p class="text-white-50">Label</p>
                </div>
            </div>
        </div>
        
        <!-- Data Tables -->
        <div class="glass-card p-4">
            <table class="table table-dark align-middle">
                <!-- Table content -->
            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
```

### 3. Form Pages
```php
<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="main-content">
    <div class="container py-5">
        <div class="glass-card p-4">
            <h2 class="gradient-text-yellow mb-4">Form Title</h2>
            <form method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="field" required>
                    <label>Field Label</label>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="back-url" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-glass btn-primary-glass">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
```

## Animations

### CSS Animations
```css
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}
```

### Animation Classes
- `.animate__animated`: Base animation class
- `.animate__fadeInUp`: Fade in from bottom
- `.animate__zoomIn`: Zoom in effect
- `.animate__pulse`: Pulsing animation

## Responsive Design

### Breakpoints
```css
@media (max-width: 768px) {
    .hero h1 { font-size: 2.5rem; }
    .hero-cta { flex-direction: column; }
    .btn-glass { width: 100%; max-width: 300px; }
}

@media (max-width: 576px) {
    .hero h1 { font-size: 2rem; }
    .register-card { margin: 0.5rem; padding: 1.5rem 1rem; }
}
```

## Implementation Guidelines

### 1. CSS Organization
- Use CSS variables for consistent theming
- Avoid inline styles - use classes instead
- Group related styles together
- Use semantic class names

### 2. HTML Structure
- Always wrap page content in `.main-content`
- Use Bootstrap grid system for layout
- Include proper ARIA labels for accessibility
- Use semantic HTML elements

### 3. JavaScript Integration
- Use Bootstrap's JavaScript components
- Implement smooth transitions
- Add loading states for better UX
- Handle form validation gracefully

### 4. Performance Considerations
- Minimize CSS and JavaScript
- Use CDN for external libraries
- Optimize images and assets
- Implement lazy loading where appropriate

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Accessibility Features

- High contrast color scheme
- Proper heading hierarchy
- ARIA labels and roles
- Keyboard navigation support
- Screen reader compatibility

## File Structure

```
public/assets/css/
├── main.css          # Unified design system
├── style.css         # Legacy styles (if needed)
└── aurora-table.css  # Table-specific styles

app/views/
├── layout/
│   ├── header.php    # Navigation and meta
│   └── footer.php    # Scripts and footer
├── admin/           # Admin pages
├── student/         # Student pages
├── company/         # Company pages
└── home/           # Landing page
```

## Migration Checklist

For existing pages, ensure:

1. ✅ Remove inline styles
2. ✅ Use unified CSS classes
3. ✅ Implement proper layout structure
4. ✅ Add responsive design
5. ✅ Include proper animations
6. ✅ Test accessibility
7. ✅ Validate HTML/CSS
8. ✅ Test cross-browser compatibility

## Future Enhancements

- Dark/light theme toggle
- Custom animation library
- Advanced form components
- Data visualization components
- Progressive Web App features
- Advanced accessibility features

---

*This design system ensures consistency across all pages while maintaining the modern, professional appearance established by the landing page.* 