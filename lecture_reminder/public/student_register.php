<?php require_once __DIR__ . '/../config/db.php'; $msg=''; if($_SERVER['REQUEST_METHOD']==='POST'){ $matric = $_POST['matric_no']??''; $username = $_POST['username']??''; $fullname = $_POST['fullname']??''; $sex = $_POST['sex']??''; $department = $_POST['department']??''; $email = $_POST['email']??''; $password = $_POST['password']??''; $confirm = $_POST['confirm']??''; if(!$username || !$email || !$password || !$confirm || $password!==$confirm) $msg='Please fill fields and ensure passwords match.'; else { try{ $st = $pdo->prepare('INSERT INTO users (matric_no,username,fullname,sex,department,email,password,role) VALUES (?,?,?,?,?,?,?,?)'); $st->execute([$matric,$username,$fullname,$sex,$department,$email,password_hash($password,PASSWORD_DEFAULT),'student']); header('Location: login.php'); exit; }catch(Exception $e){ $msg='Registration failed: '.$e->getMessage(); } } } ?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Register</title>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link rel="stylesheet" href="styles.css">
</head><body class='hold-transition register-page'>
<div class='container py-5'>
	<div class='row justify-content-center'>
		<div class='col-md-6 col-lg-5'>
			<div class='card'>
				<div class='card-body register-card-body'>
					<h3 class='text-center mb-3'>Register as Student</h3>
					<?php if($msg):?><div class='alert alert-info'><?=htmlspecialchars($msg)?></div><?php endif;?>
					<form method='post'>
						<input name='matric_no' class='form-control mb-2' placeholder='Matric No'>
                        <input name='username' class='form-control mb-2' placeholder='Username'>
						<input name='email' class='form-control mb-2' placeholder='Email'>
						<input name='fullname' class='form-control mb-2' placeholder='Full name'>
						<select name='sex' class='form-control mb-2'><option>Male</option><option>Female</option><option>Other</option></select>
						<input name='department' class='form-control mb-2' placeholder='Department'>
						<input type='password' name='password' class='form-control mb-2' placeholder='Password'>
						<input type='password' name='confirm' class='form-control mb-2' placeholder='Confirm Password'>
						<button class='btn btn-primary w-100'>Register</button>
						</form>
						<div class="text-center mt-3">
							<a href="login.php" class="btn btn-success">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
									<path fill-rule="evenodd" d="M6 3a.5.5 0 0 1 .5.5v2.5h5.793l-1.147-1.146a.5.5 0 1 1 .708-.708l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L12.293 9H6.5V11.5a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 6 3z"/>
									<path fill-rule="evenodd" d="M13.5 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H13a.5.5 0 0 1 .5.5z"/>
								</svg>
								<span class="ms-2">Login</span>
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
