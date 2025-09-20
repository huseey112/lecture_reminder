<?php session_start(); require_once __DIR__ . '/../config/db.php'; if(!isset($_SESSION['user_id'])){header('Location: login.php');exit;} if($_SESSION['role']!='admin'){ header('Location: login.php'); exit; } $action=$_GET['action']??'list'; if($action=='create' && $_SERVER['REQUEST_METHOD']==='POST'){ $user=$_POST['username']; $name=$_POST['fullname']; $email=$_POST['email']; $pw=$_POST['password']?:'Lect@123'; $pdo->prepare('INSERT INTO users (username,fullname,email,password,role) VALUES (?,?,?,?,"lecturer")')->execute([$user,$name,$email,password_hash($pw,PASSWORD_DEFAULT)]); header('Location: lecturers.php'); exit; } if($action=='list'){ $rows=$pdo->query("SELECT * FROM users WHERE role='lecturer'")->fetchAll(); } if($action=='delete' && isset($_GET['id'])){ $pdo->prepare('DELETE FROM users WHERE id=?')->execute([$_GET['id']]); header('Location: lecturers.php'); exit; } ?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Lecturers</title>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link rel="stylesheet" href="styles.css">
</head><body class='hold-transition'>
<div class='container p-4'>
		<a href="javascript:history.back()" class="btn btn-light mb-3" title="Back">
			<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
			</svg>
			<span class="d-none d-sm-inline">Back</span>
		</a>
		<h3>Lecturers</h3>
	<?php if($action=='list'): ?>
		<p><a class='btn btn-primary' href='lecturers.php?action=create'>Add Lecturer</a></p>
		<div class="table-responsive">
			<table class='table table-striped'>
				<thead><tr><th>Username</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead>
				<tbody>
				<?php foreach($rows as $r): ?>
					<tr>
						<td><?=htmlspecialchars($r['username'])?></td>
						<td><?=htmlspecialchars($r['fullname'])?></td>
						<td><?=htmlspecialchars($r['email'])?></td>
						<td><a class='btn btn-sm btn-danger' href='lecturers.php?action=delete&id=<?=$r['id']?>' onclick='return confirm("Delete?")'>Delete</a></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	<?php else: ?>
		<form method='post' class="mx-auto" style="max-width:400px;">
			<input name='username' class='form-control mb-2' placeholder='Username'>
			<input name='fullname' class='form-control mb-2' placeholder='Full name'>
			<input name='email' class='form-control mb-2' placeholder='Email'>
			<input name='password' class='form-control mb-2' placeholder='Password'>
			<button class='btn btn-primary w-100'>Create</button> <a class='btn btn-secondary w-100 mt-2' href='lecturers.php'>Cancel</a>
		</form>
	<?php endif; ?>
</div>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
