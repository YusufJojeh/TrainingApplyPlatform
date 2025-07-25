-- SQL schema for Practical Training Requests System (Professional Version)
-- Drops previous tables, creates new schema, and inserts sample data

-- DROP TABLES (in reverse dependency order)
DROP TABLE IF EXISTS activity_logs;
DROP TABLE IF EXISTS admin_logs;
DROP TABLE IF EXISTS company_reviews;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS companies;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS admins;

-- CREATE TABLES
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    major VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    cv VARCHAR(255),
    linkedin VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    field VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    description TEXT,
    website VARCHAR(255),
    logo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    company_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
    INDEX idx_student (student_id),
    INDEX idx_company (company_id)
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    user_type ENUM('student', 'company', 'admin') NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id, user_type)
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    sender_type ENUM('student', 'company', 'admin') NOT NULL,
    receiver_id INT NOT NULL,
    receiver_type ENUM('student', 'company', 'admin') NOT NULL,
    subject VARCHAR(255) DEFAULT NULL,
    content TEXT NOT NULL,
    application_id INT DEFAULT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_sender (sender_id, sender_type),
    INDEX idx_receiver (receiver_id, receiver_type),
    INDEX idx_application (application_id),
    FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE SET NULL
);

CREATE TABLE company_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    student_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    INDEX idx_company (company_id),
    INDEX idx_student (student_id)
);

CREATE TABLE admin_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE
);

CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    user_type ENUM('student', 'company', 'admin') NOT NULL,
    activity VARCHAR(255) NOT NULL,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id, user_type)
);

-- SAMPLE DATA
-- Admins
INSERT INTO admins (username, password, email) VALUES
('admin', 'admin123', 'admin@trainingsystem.com'),
('supervisor', 'supervisor123', 'supervisor@trainingsystem.com');

-- Students
INSERT INTO students (name, email, username, password, major, city, cv, linkedin) VALUES
('Fatima Al-Sayed', 'fatima@student.com', 'fatima', 'pass123', 'Economics', 'Cairo', 'uploads/cv_fatima.pdf', 'https://linkedin.com/in/fatima'),
('Ahmed Hassan', 'ahmed@student.com', 'ahmed', 'pass456', 'Engineering', 'Riyadh', 'uploads/cv_ahmed.pdf', 'https://linkedin.com/in/ahmed'),
('Layla Noor', 'layla@student.com', 'layla', 'pass789', 'Business', 'Jeddah', NULL, NULL);

-- Companies
INSERT INTO companies (name, email, username, password, field, city, description, website, logo) VALUES
('Tech Innovators', 'hr@techinnovators.com', 'techinnovators', 'company123', 'Technology', 'Dubai', 'Leading tech company in the region.', 'https://techinnovators.com', 'uploads/logo_tech.png'),
('Eco Solutions', 'contact@ecosolutions.com', 'ecosolutions', 'eco123', 'Environment', 'Amman', 'Eco-friendly solutions for a better world.', 'https://ecosolutions.com', 'uploads/logo_eco.png'),
('Finance Pros', 'info@financepros.com', 'financepros', 'finance123', 'Finance', 'Cairo', 'Top finance consulting firm.', 'https://financepros.com', NULL);

-- Applications
INSERT INTO applications (student_id, company_id, status, comment) VALUES
(1, 1, 'pending', 'Looking forward to this opportunity.'),
(2, 2, 'accepted', 'Congratulations!'),
(3, 3, 'rejected', 'We are looking for more experience.');

-- Messages
INSERT INTO messages (sender_id, sender_type, receiver_id, receiver_type, subject, content, application_id) VALUES
(1, 'student', 1, 'company', 'Internship Application', 'I am interested in your internship program. Please consider my application.', 1),
(1, 'company', 1, 'student', 'Application Received', 'Your application has been received. We will review it and get back to you soon.', 1),
(2, 'company', 2, 'student', 'Application Accepted', 'Your application has been accepted. Welcome to our team!', 2),
(3, 'company', 3, 'student', 'Application Update', 'Thank you for your interest. Unfortunately, we are looking for candidates with more experience.', 3);