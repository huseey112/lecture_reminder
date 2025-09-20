<?php
require_once __DIR__ . '/../config/db.php';
// Optionally create tables by executing SQL file
// $pdo->exec(file_get_contents(__DIR__ . '/../sql/create_tables.sql'));

function run($pdo, $sql, $params=[]){
    $st = $pdo->prepare($sql);
    $st->execute($params);
    return $pdo->lastInsertId();
}

$admin_pw = password_hash('Admin@123', PASSWORD_DEFAULT);
$lect_pw = password_hash('Lect@123', PASSWORD_DEFAULT);
$stud_pw = password_hash('Stud@123', PASSWORD_DEFAULT);

run($pdo, "INSERT IGNORE INTO users (username,fullname,email,password,role) VALUES (?,?,?,?,?)", ['admin','Admin User','admin@example.com',$admin_pw,'admin']);
run($pdo, "INSERT IGNORE INTO users (username,fullname,email,password,role) VALUES (?,?,?,?,?)", ['lect1','Fatima Bello','fatima@example.com',$lect_pw,'lecturer']);
run($pdo, "INSERT IGNORE INTO users (username,fullname,email,password,role) VALUES (?,?,?,?,?)", ['lect2','Ahmed Musa','ahmed@example.com',$lect_pw,'lecturer']);

run($pdo, "INSERT IGNORE INTO users (username,fullname,matric_no,sex,department,email,password,role) VALUES (?,?,?,?,?,?,?,?)", ['MAT2025001','Hannah Okoro','MAT/2025/001','Female','Computer Science','hannah@example.com',$stud_pw,'student']);
run($pdo, "INSERT IGNORE INTO users (username,fullname,matric_no,sex,department,email,password,role) VALUES (?,?,?,?,?,?,?,?)", ['MAT2025002','John Ade','MAT/2025/002','Male','Computer Science','john@example.com',$stud_pw,'student']);
run($pdo, "INSERT IGNORE INTO users (username,fullname,matric_no,sex,department,email,password,role) VALUES (?,?,?,?,?,?,?,?)", ['MAT2025003','Grace Ibrahim','MAT/2025/003','Female','Computer Engineering','grace@example.com',$stud_pw,'student']);

run($pdo, "INSERT IGNORE INTO courses (code,title) VALUES (?,?)", ['MTH101','Mathematics I']);
run($pdo, "INSERT IGNORE INTO courses (code,title) VALUES (?,?)", ['PHY101','Physics I']);

run($pdo, "INSERT IGNORE INTO timetables (course_id,lecturer_id,venue,day_of_week,start_time,end_time) VALUES (?,?,?,?,?,?)", [1,2,'Lecture Hall A','Mon','09:00:00','10:30:00']);
run($pdo, "INSERT IGNORE INTO timetables (course_id,lecturer_id,venue,date,start_time,end_time) VALUES (?,?,?,?,?,?)", [2,3,'Lab 1', date('Y-m-d', strtotime('+1 day')), '11:00:00','12:30:00']);

run($pdo, "INSERT IGNORE INTO enrolments (student_id, course_id) VALUES (?,?)", [4, 1]);
run($pdo, "INSERT IGNORE INTO enrolments (student_id, course_id) VALUES (?,?)", [5, 1]);
run($pdo, "INSERT IGNORE INTO enrolments (student_id, course_id) VALUES (?,?)", [6, 2]);

run($pdo, "INSERT IGNORE INTO reminders (title,message,created_by,scheduled_at) VALUES (?,?,?,?)", ['Orientation','Orientation at Admin Hall',1, date('Y-m-d H:i:s', strtotime('+2 hours'))]);
run($pdo, "INSERT IGNORE INTO reminders (title,message,created_by,scheduled_at) VALUES (?,?,?,?)", ['Math Lecture','Mathematics lecture scheduled tomorrow',2, date('Y-m-d H:i:s', strtotime('+1 day'))]);

echo "SEED COMPLETE. Admin: admin/Admin@123, Lecturers: lect1/lect2 (Lect@123), Students: MAT2025001..3 (Stud@123)\n";
