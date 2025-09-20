<?php session_start(); require_once __DIR__ . '/../config/db.php'; if(!isset($_SESSION['user_id'])){ header('Location: login.php'); exit; } $role = $_SESSION['role']; $uid = $_SESSION['user_id']; $action = $_GET['action'] ?? 'list'; if($action=='create' && $_SERVER['REQUEST_METHOD']==='POST'){ $title = $_POST['title']; $message = $_POST['message']; $target = $_POST['target_user']?:null; $sched = $_POST['scheduled_at']?:null; $pdo->prepare('INSERT INTO reminders (title,message,created_by,target_user_id,scheduled_at) VALUES (?,?,?,?,?)')->execute([$title,$message,$uid,$target,$sched]); header('Location: reminders.php'); exit; } if($action=='delete' && isset($_GET['id'])){ $id=(int)$_GET['id']; if($role=='admin'){ $pdo->prepare('DELETE FROM reminders WHERE id=?')->execute([$id]); } else { $pdo->prepare('DELETE FROM reminders WHERE id=? AND created_by=?')->execute([$id,$uid]); } header('Location: reminders.php'); exit; } if($action=='list'){ if($role=='admin') $rows = $pdo->query('SELECT r.*, u.fullname as creator FROM reminders r JOIN users u ON r.created_by=u.id ORDER BY r.scheduled_at DESC')->fetchAll(); elseif($role=='lecturer'){ $st=$pdo->prepare('SELECT r.*, u.fullname as creator FROM reminders r JOIN users u ON r.created_by=u.id WHERE r.created_by=? ORDER BY r.scheduled_at DESC'); $st->execute([$uid]); $rows=$st->fetchAll(); } else { $st=$pdo->prepare('SELECT r.*, u.fullname as creator FROM reminders r JOIN users u ON r.created_by=u.id WHERE (r.target_user_id IS NULL OR r.target_user_id=? ) ORDER BY r.scheduled_at DESC'); $st->execute([$uid]); $rows=$st->fetchAll(); } } $users = $pdo->query('SELECT id,fullname,username FROM users')->fetchAll(); ?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Reminders</title>
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
		<h3>Reminders</h3>
	<?php if($action=='list'): ?>
		<?php if($role!='student'): ?>
			<p><a class='btn btn-primary' href='reminders.php?action=create'>Create Reminder</a></p>
		<?php endif; ?>
		<div class="table-responsive">
			<table class='table table-striped'>
				<thead><tr><th>Title</th><th>Message</th><th>By</th><th>Scheduled</th><th>Actions</th></tr></thead>
				<tbody>
				<?php foreach($rows as $r): ?>
					<tr>
						<td><?=htmlspecialchars($r['title'])?></td>
						<td><?=htmlspecialchars($r['message'])?></td>
						<td><?=htmlspecialchars($r['creator'])?></td>
						<td><?=htmlspecialchars($r['scheduled_at'])?></td>
						<td>
							<?php if($role=='admin' || ($role=='lecturer' && $r['created_by']==$uid)): ?>
								<a class='btn btn-sm btn-danger' href='reminders.php?action=delete&id=<?=$r['id']?>'>Delete</a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	<?php else: ?>
		<form method='post' class="mx-auto" style="max-width:500px;">
			<input name='title' class='form-control mb-2' placeholder='Title' required>
			<textarea name='message' class='form-control mb-2' placeholder='Message' required></textarea>
			<select name='target_user' class='form-control mb-2'>
				<option value=''>All</option>
				<?php foreach($users as $u): ?>
					<option value='<?=$u['id']?>'><?=$u['fullname']?> (<?=$u['username']?>)</option>
				<?php endforeach;?>
			</select>
			<input name='scheduled_at' class='form-control mb-2' placeholder='YYYY-MM-DD HH:MM:SS'>
			<button class='btn btn-primary w-100'>Create</button> <a class='btn btn-secondary w-100 mt-2' href='reminders.php'>Cancel</a>
		</form>
	<?php endif; ?>
</div>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
