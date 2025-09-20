<?php
function send_email($to, $subject, $body){
    if(!filter_var($to, FILTER_VALIDATE_EMAIL)) return false;
    $headers = 'From: noreply@lecture-reminder.local\r\n' . 'Reply-To: noreply@lecture-reminder.local\r\n' . 'Content-Type: text/plain; charset=utf-8\r\n';
    return mail($to, $subject, $body, $headers);
}
?>
