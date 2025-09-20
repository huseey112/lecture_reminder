<?php
session_start(); require_once __DIR__ . '/../config/db.php'; $err='';
if($_SERVER['REQUEST_METHOD']==='POST'){ $username = trim($_POST['username'] ?? ''); $password = $_POST['password'] ?? ''; $st = $pdo->prepare('SELECT id,password,role FROM users WHERE username=? LIMIT 1'); $st->execute([$username]); $u = $st->fetch();
if($u && password_verify($password, $u['password'])){ session_regenerate_id(true); $_SESSION['user_id'] = $u['id']; $_SESSION['role'] = $u['role']; if($u['role']=='admin') header('Location: admin_dashboard.php'); elseif($u['role']=='lecturer') header('Location: lecturer_dashboard.php'); else header('Location: student_dashboard.php'); exit; } else $err = 'Invalid credentials'; }
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Login</title>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link rel="stylesheet" href="styles.css">
</head>
<body class='hold-transition login-page'>
<div class='container py-5'>
	<div class='row justify-content-center'>
		<div class='col-md-5'>
			<div class='card'>
				<div class='card-body login-card-body'>
					<h3 class='text-center mb-4'><b>Lecture</b>Reminder</h3>
					<p class='login-box-msg'>Sign in</p>
					<?php if($err):?><div class='alert alert-danger'><?=htmlspecialchars($err)?></div><?php endif;?>
								<form method='post'>
									<div class='mb-3'>
										<input name='username' class='form-control' placeholder='Username'>
									</div>
									<div class='mb-3'>
										<input type='password' name='password' class='form-control' placeholder='Password'>
									</div>
									<div class='d-flex justify-content-between align-items-center mb-3'>
										<a href='forgot_password.php'>Forgot password?</a>
										<button class='btn btn-primary'>Sign In</button>
									</div>
								</form>
								<div class="text-center mt-3">
									<a href="student_register.php" class="btn btn-success">
										<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
											<path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
											<path fill-rule="evenodd" d="M6 9a5 5 0 0 0-4.546 2.914A.5.5 0 0 0 1.5 12h7a.5.5 0 0 0 .447-.724A5 5 0 0 0 6 9z"/>
											<path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
										</svg>
										<span class="ms-2">Student Register</span>
									</a>
								</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
