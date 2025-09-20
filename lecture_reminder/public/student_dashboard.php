<?php session_start(); require_once __DIR__ . '/../config/db.php'; if(!isset($_SESSION['user_id'])||$_SESSION['role']!='student'){header('Location: login.php');exit;} $uid=$_SESSION['user_id']; $up = $pdo->prepare('SELECT fullname,matric_no,department FROM users WHERE id=?'); $up->execute([$uid]); $user = $up->fetch(); ?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Student</title>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link rel="stylesheet" href="styles.css">
</head><body class='hold-transition sidebar-mini'>
<div class='wrapper'>
<nav class='main-header navbar navbar-expand-md navbar-light navbar-white'>
	<div class='container'>
		<a class='navbar-brand fw-bold' href='#'>Student Dashboard</a>
		<ul class='navbar-nav ms-auto'>
			<li class='nav-item'><a class='btn btn-outline-danger ms-2' href='logout.php'>Logout</a></li>
		</ul>
	</div>
</nav>
<div class='content-wrapper'><div class='content p-4'>
	<h3>Welcome <?=htmlspecialchars($user['fullname'])?></h3>
	<p>Matric: <?=htmlspecialchars($user['matric_no'])?> | Dept: <?=htmlspecialchars($user['department'])?></p>
	<p><a class='btn btn-primary' href='timetable.php'>View Timetable</a> <a class='btn btn-secondary' href='reminders.php'>View Reminders</a></p>
</div></div><footer class='main-footer'><strong>&copy; 2025</strong></footer></div>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
