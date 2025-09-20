<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../lib/notifications.php';
$now = date('Y-m-d H:i:s');
$stmt = $pdo->prepare("SELECT q.*, u.email FROM notifications_queue q JOIN users u ON q.user_id = u.id WHERE q.status='pending' AND q.scheduled_at <= ? LIMIT 100");
$stmt->execute([$now]);
while($row = $stmt->fetch()){
    $ok = send_email($row['email'], 'Lecture Reminder', $row['message']);
    if($ok){
        $upd = $pdo->prepare('UPDATE notifications_queue SET status=?, sent_at=? WHERE id=?');
        $upd->execute(['sent', date('Y-m-d H:i:s'), $row['id']]);
    } else {
        $upd = $pdo->prepare('UPDATE notifications_queue SET status=? WHERE id=?');
        $upd->execute(['failed', $row['id']]);
    }
}
echo "Worker done\n";
