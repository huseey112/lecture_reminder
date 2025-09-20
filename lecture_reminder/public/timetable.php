<?php
session_start();
require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['user_id']) || $_SESSION['role']!='student'){
    header('Location: login.php');
    exit;
}
$uid = $_SESSION['user_id'];
$timetables = $pdo->prepare('SELECT t.*, c.code, c.title, u.fullname as lecturer FROM timetables t JOIN courses c ON t.course_id=c.id LEFT JOIN users u ON t.lecturer_id=u.id WHERE t.id IN (SELECT timetable_id FROM student_timetables WHERE student_id=?)');
$timetables->execute([$uid]);
$rows = $timetables->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>My Timetable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container py-5">
    <a href="javascript:history.back()" class="btn btn-light mb-3" title="Back">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
        </svg>
        <span class="d-none d-sm-inline">Back</span>
    </a>
    <h3>My Timetable</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Lecturer</th>
                    <th>Date/Day</th>
                    <th>Time</th>
                    <th>Venue</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($rows as $r): ?>
                <tr>
                    <td><?=htmlspecialchars($r['code'].' - '.$r['title'])?></td>
                    <td><?=htmlspecialchars($r['lecturer'])?></td>
                    <td><?= $r['date'] ? $r['date'] : $r['day_of_week'] ?></td>
                    <td><?=htmlspecialchars($r['start_time'].' - '.$r['end_time'])?></td>
                    <td><?=htmlspecialchars($r['venue'])?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
