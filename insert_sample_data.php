<?php
// insert_sample_data.php - Populate practical_training database with sample data (plain text passwords)

$host = 'localhost';
$db   = 'practical_training';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Admins
$admins = [
    ['admin', 'admin123', 'admin@trainingsystem.com'],
    ['supervisor', 'supervisor123', 'supervisor@trainingsystem.com'],
];
foreach ($admins as $a) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO admins (username, password, email) VALUES (?, ?, ?)");
    $stmt->execute([$a[0], $a[1], $a[2]]);
}

// Students
$students = [
    ['Fatima Al-Sayed', 'fatima@student.com', 'fatima', 'pass123', 'Economics', 'Cairo', 'uploads/cv_fatima.pdf', 'https://linkedin.com/in/fatima'],
    ['Ahmed Hassan', 'ahmed@student.com', 'ahmed', 'pass456', 'Engineering', 'Riyadh', 'uploads/cv_ahmed.pdf', 'https://linkedin.com/in/ahmed'],
    ['Layla Noor', 'layla@student.com', 'layla', 'pass789', 'Business', 'Jeddah', NULL, NULL],
];
foreach ($students as $s) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO students (name, email, username, password, major, city, cv, linkedin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute($s);
}
// Fetch student IDs by username
$student_ids = [];
foreach ($students as $s) {
    $stmt = $pdo->prepare("SELECT id FROM students WHERE username = ?");
    $stmt->execute([$s[2]]);
    $student_ids[$s[2]] = $stmt->fetchColumn();
}

// Companies
$companies = [
    ['Tech Innovators', 'hr@techinnovators.com', 'techinnovators', 'company123', 'Technology', 'Dubai', 'Leading tech company in the region.', 'https://techinnovators.com', 'uploads/logo_tech.png'],
    ['Eco Solutions', 'contact@ecosolutions.com', 'ecosolutions', 'eco123', 'Environment', 'Amman', 'Eco-friendly solutions for a better world.', 'https://ecosolutions.com', 'uploads/logo_eco.png'],
    ['Finance Pros', 'info@financepros.com', 'financepros', 'finance123', 'Finance', 'Cairo', 'Top finance consulting firm.', 'https://financepros.com', NULL],
];
foreach ($companies as $c) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO companies (name, email, username, password, field, city, description, website, logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute($c);
}
// Fetch company IDs by username
$company_ids = [];
foreach ($companies as $c) {
    $stmt = $pdo->prepare("SELECT id FROM companies WHERE username = ?");
    $stmt->execute([$c[2]]);
    $company_ids[$c[2]] = $stmt->fetchColumn();
}

// Applications
$applications = [
    // username, company_username, status, comment
    ['fatima', 'techinnovators', 'pending', 'Looking forward to this opportunity.'],
    ['ahmed', 'ecosolutions', 'accepted', 'Congratulations!'],
    ['layla', 'financepros', 'rejected', 'We are looking for more experience.'],
];
foreach ($applications as $a) {
    $stmt = $pdo->prepare("INSERT INTO applications (student_id, company_id, status, comment) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $student_ids[$a[0]], $company_ids[$a[1]], $a[2], $a[3]
    ]);
}

// Company Reviews
$reviews = [
    // company_username, student_username, rating, review
    ['techinnovators', 'fatima', 5, 'Amazing experience!'],
    ['ecosolutions', 'ahmed', 4, 'Great company, learned a lot.'],
    ['financepros', 'layla', 3, 'Good, but could be better.'],
];
foreach ($reviews as $r) {
    $stmt = $pdo->prepare("INSERT INTO company_reviews (company_id, student_id, rating, review) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $company_ids[$r[0]], $student_ids[$r[1]], $r[2], $r[3]
    ]);
}

// Messages
$messages = [
    // sender_username, sender_type, receiver_username, receiver_type, content
    ['fatima', 'student', 'techinnovators', 'company', 'Hello, I am interested in your internship.'],
    ['techinnovators', 'company', 'ahmed', 'student', 'Thank you for applying!'],
    ['admin', 'admin', 'fatima', 'student', 'Welcome to the platform!'],
];
// Fetch admin id
$stmt = $pdo->prepare("SELECT id FROM admins WHERE username = ?");
$stmt->execute(['admin']);
$admin_id = $stmt->fetchColumn();
foreach ($messages as $m) {
    $sender_id = $m[1] === 'student' ? $student_ids[$m[0]] : ($m[1] === 'company' ? $company_ids[$m[0]] : $admin_id);
    $receiver_id = $m[3] === 'student' ? $student_ids[$m[2]] : ($m[3] === 'company' ? $company_ids[$m[2]] : $admin_id);
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, sender_type, receiver_id, receiver_type, content) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$sender_id, $m[1], $receiver_id, $m[3], $m[4]]);
}

// Notifications
$notifications = [
    // username, user_type, message, is_read
    ['fatima', 'student', 'Your application has been received.', 0],
    ['techinnovators', 'company', 'You have a new applicant.', 0],
    ['admin', 'admin', 'System maintenance scheduled.', 1],
];
foreach ($notifications as $n) {
    $user_id = $n[1] === 'student' ? $student_ids[$n[0]] : ($n[1] === 'company' ? $company_ids[$n[0]] : $admin_id);
    $stmt = $pdo->prepare("INSERT INTO notifications (user_id, user_type, message, is_read) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $n[1], $n[2], $n[3]]);
}

// Activity Logs
$logs = [
    // username, user_type, activity, details
    ['fatima', 'student', 'Registered', 'Student registered on the platform.'],
    ['techinnovators', 'company', 'Posted Internship', 'Company posted a new internship.'],
    ['admin', 'admin', 'Reviewed Application', 'Admin reviewed an application.'],
];
foreach ($logs as $l) {
    $user_id = $l[1] === 'student' ? $student_ids[$l[0]] : ($l[1] === 'company' ? $company_ids[$l[0]] : $admin_id);
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, user_type, activity, details) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $l[1], $l[2], $l[3]]);
}

// Admin Logs
$admin_logs = [
    // admin_username, action, details
    ['admin', 'Login', 'Admin logged in.'],
    ['admin', 'Update Settings', 'Changed notification settings.'],
];
foreach ($admin_logs as $al) {
    $stmt = $pdo->prepare("SELECT id FROM admins WHERE username = ?");
    $stmt->execute([$al[0]]);
    $aid = $stmt->fetchColumn();
    $stmt = $pdo->prepare("INSERT INTO admin_logs (admin_id, action, details) VALUES (?, ?, ?)");
    $stmt->execute([$aid, $al[1], $al[2]]);
}

echo "Sample data inserted successfully (plain text passwords).\n"; 