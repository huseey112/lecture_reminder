-- Lecture Reminder System schema
CREATE DATABASE IF NOT EXISTS lecture_reminder CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lecture_reminder;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  fullname VARCHAR(200) DEFAULT NULL,
  matric_no VARCHAR(100) DEFAULT NULL,
  sex ENUM('Male','Female','Other') DEFAULT NULL,
  department VARCHAR(255) DEFAULT NULL,
  email VARCHAR(255) DEFAULT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','lecturer','student') NOT NULL DEFAULT 'student',
  phone VARCHAR(50) DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) NOT NULL,
  title VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS timetables (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT NOT NULL,
  lecturer_id INT NULL,
  venue VARCHAR(255),
  day_of_week ENUM('Mon','Tue','Wed','Thu','Fri','Sat','Sun') DEFAULT NULL,
  date DATE DEFAULT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS enrolments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  course_id INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS reminders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  created_by INT NOT NULL,
  target_user_id INT DEFAULT NULL,
  scheduled_at DATETIME DEFAULT NULL,
  channel ENUM('email','sms','push') DEFAULT 'email',
  status ENUM('active','cancelled') DEFAULT 'active',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS notifications_queue (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reminder_id INT DEFAULT NULL,
  timetable_id INT DEFAULT NULL,
  user_id INT DEFAULT NULL,
  channel ENUM('email','sms','push') NOT NULL,
  message TEXT NOT NULL,
  scheduled_at DATETIME NOT NULL,
  sent_at DATETIME DEFAULT NULL,
  status ENUM('pending','sent','failed') DEFAULT 'pending',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS password_resets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  token VARCHAR(255) NOT NULL,
  expires_at DATETIME NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS attendance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  timetable_id INT NOT NULL,
  student_id INT NOT NULL,
  status ENUM('present','absent') NOT NULL,
  marked_by INT NOT NULL,
  marked_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Student-Timetable mapping table for many-to-many relationship
CREATE TABLE IF NOT EXISTS student_timetables (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  timetable_id INT NOT NULL,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (timetable_id) REFERENCES timetables(id) ON DELETE CASCADE
);
