Lecture Reminder System - XAMPP/WAMP ready (AdminLTE UI)
Project: Lecturer Reminder System (Waziri Umaru Federal Polytechnic, Birnin Kebbi)

1. Copy folder 'lecture_reminder_package' to your webroot (e.g., C:\xampp\htdocs\lecture_reminder_package).
2. Import sql/create_tables.sql into phpMyAdmin.
3. Edit config/db.php to set DB credentials if needed.
4. Run seed/seed.php once (php seed/seed.php or visit in browser) to populate existing records and sample data.
   - Admin: admin / Admin@123
   - Lecturers: lect1 / lect2  (Lect@123)
   - Students: MAT2025001..3  (Stud@123)
5. Visit public/login.php to sign in.
6. Set up a scheduled job to run worker/reminder_worker.php for notifications.
7. For production: configure SMTP in lib/notifications.php and secure the app (CSRF, HTTPS, input validation).
