<?php session_start(); require_once __DIR__ . '/../config/db.php'; if(!isset($_SESSION['user_id'])){header('Location: login.php');exit;} $role=$_SESSION['role']; $uid=$_SESSION['user_id']; $action=$_GET['action']??'list'; if($action=='create' && $_SERVER['REQUEST_METHOD']==='POST'){ $course=$_POST['course_id']; $lect=$_POST['lecturer_id']?:null; $venue=$_POST['venue']; $day=$_POST['day_of_week']?:null; $date=$_POST['date']?:null; $start=$_POST['start_time']; $end=$_POST['end_time']; $pdo->prepare('INSERT INTO timetables (course_id,lecturer_id,venue,day_of_week,date,start_time,end_time) VALUES (?,?,?,?,?,?,?)')->execute([$course,$lect,$venue,$day,$date,$start,$end]); header('Location: timetable_manage.php'); exit; } if($action=='list'){ $rows=$pdo->query('SELECT t.*, c.code, c.title, u.fullname as lecturer FROM timetables t JOIN courses c ON t.course_id=c.id LEFT JOIN users u ON t.lecturer_id=u.id')->fetchAll(); $courses=$pdo->query('SELECT * FROM courses')->fetchAll(); $lects=$pdo->query("SELECT id,fullname FROM users WHERE role='lecturer'")->fetchAll(); } ?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Timetable</title>
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
		<h3>Timetable</h3>
	<?php if($action=='list'): ?>
		<p><a class='btn btn-primary' href='timetable_manage.php?action=create'>Create Entry</a></p>
		<div class="table-responsive">
			<table class='table table-striped'>
				<thead><tr><th>Course</th><th>Lecturer</th><th>Date/Day</th><th>Time</th><th>Venue</th></tr></thead>
				<tbody>
				<?php foreach($rows as $r): ?>
					<tr>
						<td><?=htmlspecialchars($r['code'].' - '.$r['title'])?></td>
						<td><?=htmlspecialchars($r['lecturer'])?></td>
						<td><?= $r['date'] ? $r['date'] : $r['day_of_week'] ?></td>
						<td><?=htmlspecialchars($r['start_time'].' - '.$r['end_time'])?></td>
						<td><?=htmlspecialchars($r['venue'])?></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	<?php else: ?>
		<form method='post' class="mx-auto" style="max-width:500px;">
			<select name='course_id' class='form-control mb-2'>
				<?php foreach($courses as $c): ?>
					<option value='<?=$c['id']?>'><?=$c['code']?> - <?=$c['title']?></option>
				<?php endforeach;?>
			</select>
			<select name='lecturer_id' class='form-control mb-2'>
				<option value=''>--None--</option>
				<?php foreach($lects as $l): ?>
					<option value='<?=$l['id']?>'><?=$l['fullname']?></option>
				<?php endforeach;?>
			</select>
			<input name='day_of_week' class='form-control mb-2' placeholder='Day (Mon)'>
			<input name='date' class='form-control mb-2' placeholder='YYYY-MM-DD'>
			<input name='start_time' type='time' class='form-control mb-2' required>
			<input name='end_time' type='time' class='form-control mb-2' required>
			<input name='venue' class='form-control mb-2' placeholder='Venue'>
			<button class='btn btn-primary w-100'>Create</button> <a class='btn btn-secondary w-100 mt-2' href='timetable_manage.php'>Cancel</a>
		</form>
	<?php endif; ?>
</div>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
