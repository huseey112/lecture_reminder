<?php session_start(); require_once __DIR__ . '/../config/db.php'; if(!isset($_SESSION['user_id'])||$_SESSION['role']!='admin'){header('Location: login.php');exit;} $counts = $pdo->query('SELECT (SELECT COUNT(*) FROM users WHERE role="student") as students, (SELECT COUNT(*) FROM users WHERE role="lecturer") as lecturers, (SELECT COUNT(*) FROM reminders) as reminders')->fetch(); ?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Admin</title>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link rel="stylesheet" href="styles.css">
</head><body class='hold-transition sidebar-mini'>
<div class='wrapper'>
<nav class='main-header navbar navbar-expand-md navbar-light navbar-white'>
<div class='container'><a class='navbar-brand' href='#'>Admin</a><ul class='navbar-nav ms-auto'><li class='nav-item'><a class='btn btn-outline-danger ms-2' href='logout.php'>Logout</a></li></ul></div></nav><div class='content-wrapper'><div class='content p-4'><h3>Admin Dashboard</h3><div class='row'><div class='col-md-4'><div class='card p-3'><h5>Students</h5><p><?=$counts['students']?></p></div></div><div class='col-md-4'><div class='card p-3'><h5>Lecturers</h5><p><?=$counts['lecturers']?></p></div></div><div class='col-md-4'><div class='card p-3'><h5>Reminders</h5><p><?=$counts['reminders']?></p></div></div></div><p class='mt-3'><a class='btn btn-primary' href='reminders.php'>Manage Reminders</a> <a class='btn btn-secondary' href='timetable_manage.php'>Manage Timetable</a> <a class='btn btn-info' href='students.php'>Students</a> <a class='btn btn-warning' href='lecturers.php'>Lecturers</a></p></div></div><footer class='main-footer'><strong>&copy; 2025</strong></footer></div>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
