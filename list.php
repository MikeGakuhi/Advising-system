<?php
date_default_timezone_set('Africa/Nairobi');
require __DIR__ . '/helpers.php';
require __DIR__ . '/db.php';

$appointments = $pdo->query(
    'SELECT * FROM appointments ORDER BY created_at DESC'
)->fetchAll(PDO::FETCH_ASSOC);

$isSaved = isset($_GET['saved']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments - Advising System</title>
    <link rel="stylesheet" href="advising.css">
</head>
<body>
    <div class="container">
        <h1>My Appointments</h1>

        <?php if ($isSaved): ?>
            <div class="success">Request saved!</div>
        <?php endif; ?>

        <p>
            <a href="advising.html">← Request another appointment</a>
        </p>

        <?php if (empty($appointments)): ?>
            <p>No appointments yet.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Topic</th>
                            <th>Preferred Date</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $row): ?>
                        <tr>
                            <td><?= e($row['id']) ?></td>
                            <td><?= e($row['full_name']) ?></td>
                            <td><?= e($row['email']) ?></td>
                            <td>
                                <span class="badge badge-<?= e($row['topic']) ?>">
                                    <?= e($row['topic']) ?>
                                </span>
                            </td>
                            <td><?= e($row['pref_date']) ?></td>
                            <td><?= e($row['created_at']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
