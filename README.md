# Practical Training Requests System (Engineering & Economics)

## Overview
A PHP MVC web application (no framework) for managing practical training requests between students and companies in Engineering & Economics fields. Features include registration, application workflow, dashboards, filtering, and a modern Bootstrap-based frontend.

## Features
- Student & company registration/login (separate flows)
- Profile management for students and companies
- Students can apply for training, track status, and view company comments
- Companies can filter, approve/reject, and comment on applications
- Admin dashboard for managing all users and applications
- Responsive UI with Bootstrap 5, custom CSS, JS, and jQuery
- Localization-ready structure (Arabic/English)
- Secure coding: hashed passwords, prepared statements (PDO)

## Project Structure
```
/app
  /controllers
  /models
  /views
/public
  /assets (css, js, images)
index.php
/config
  database.php
README.md
schema.sql
```

## Setup Instructions
1. Import `schema.sql` into your MySQL database.
2. Configure DB credentials in `/config/database.php`.
3. Place project in your web server root (e.g., `htdocs` for XAMPP).
4. Access via `http://localhost/PRO/public`.

## Notes
- No PHP frameworks used. Composer only for autoloading (optional).
- All code is commented and modular for easy maintenance.
- UI is user-friendly and localization-ready. 