<?php
require 'helpers.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit("Method not allowed"); }
$name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$topic = $_POST['topic'] ?? '';
$date = $_POST['appointment_date'] ?? '';
if (!validate_email_usiu($email) || !validate_date_not_past($date)) {
  http_response_code(422); exit("Validation failed: check email and date not in past");
}
echo "<h1>PHP received your request (Checkpoint 1 - NO DB SAVE)</h1>";
echo "<p>Name: ".htmlspecialchars($name)."<br>Email: ".htmlspecialchars($email)."<br>Topic: ".htmlspecialchars($topic)."<br>Date: ".htmlspecialchars($date)."</p>";
echo "<p><a href='list.php'>Go to List</a></p>";
?>
