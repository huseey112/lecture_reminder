<?php require_once __DIR__ . '/../config/db.php'; $info=''; $show_reset_form=false; $fullname=''; $email=''; if($_SERVER['REQUEST_METHOD']==='POST'){ $fullname=trim($_POST['fullname']??''); $email=trim($_POST['email']??''); if($fullname && $email){ $st=$pdo->prepare('SELECT id FROM users WHERE fullname=? AND email=? LIMIT 1'); $st->execute([$fullname,$email]); $u=$st->fetch(); if($u){ $show_reset_form=true; $user_id=$u['id']; } else $info='No matching user'; } else $info='Provide full name and email'; } if(isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_POST['user_id'])){ $new_password=trim($_POST['new_password']); $confirm_password=trim($_POST['confirm_password']); $user_id=(int)$_POST['user_id']; if($new_password && $confirm_password && $new_password===$confirm_password){ $pdo->prepare('UPDATE users SET password=? WHERE id=?')->execute([password_hash($new_password,PASSWORD_DEFAULT),$user_id]); $info='Password reset successful. <a href="login.php">Login</a>'; $show_reset_form=false; } else { $info='Passwords do not match.'; $show_reset_form=true; } } ?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Forgot</title>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link rel="stylesheet" href="styles.css">
</head><body>
<div class="container py-5">
<?php if($show_reset_form): ?>
	<form method="post" class="mx-auto" style="max-width:400px;">
		<h3 class="mb-3">Reset Password</h3>
		<input type="hidden" name="user_id" value="<?=htmlspecialchars($user_id)?>">
		<input type="password" name="new_password" class="form-control mb-2" placeholder="New Password">
		<input type="password" name="confirm_password" class="form-control mb-2" placeholder="Confirm Password">
		<button class="btn btn-success w-100">Reset Password</button>
	</form>
<?php else: ?>
	<form method='post' class="mx-auto" style="max-width:400px;">
		<h3 class="mb-3">Forgot Password</h3>
		<input name='fullname' class="form-control mb-2" placeholder='Full name' value="<?=htmlspecialchars($fullname)?>">
		<input name='email' class="form-control mb-2" placeholder='Email' value="<?=htmlspecialchars($email)?>">
		<button class="btn btn-primary w-100">Request</button>
	</form>
<?php endif; ?>
	<?php if($info) echo '<p class="alert alert-info mt-3">'.($info).'</p>'; ?>
</div>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
