<?php
date_default_timezone_set('Africa/Nairobi');
require __DIR__ . '/helpers.php';
require __DIR__ . '/db.php';

$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$topic = trim($_POST['topic'] ?? '');
$pref_date = trim($_POST['pref_date'] ?? '');

$errors = [];

if ($full_name === '' || mb_strlen($full_name) < 2) {
    $errors[] = 'Full name is required (min 2 chars).';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email is required.';
}
$allowed = ['academic','career','personal'];
if (!in_array($topic, $allowed, true)) {
    $errors[] = 'Invalid topic.';
}
$today = new DateTime('today');
$d = DateTime::createFromFormat('Y-m-d', $pref_date);
if (!$d || $d->format('Y-m-d') !== $pref_date) {
    $errors[] = 'Preferred date is invalid.';
} elseif ($d < $today) {
    $errors[] = 'Preferred date cannot be in the past.';
}

if ($errors) {
    http_response_code(422);
    echo '<h1>Check your request</h1><ul>';
    foreach ($errors as $er) {
        echo '<li>' . e($er) . '</li>';
    }
    echo '</ul><p><a href="advising.html">Return to form</a></p>';
    exit;
}

$stmt = $pdo->prepare('INSERT INTO appointments (full_name, email, topic, pref_date) VALUES (?, ?, ?, ?)');
$stmt->execute([$full_name, $email, $topic, $pref_date]);

header('Location: list.php?saved=1', true, 303);
exit;
