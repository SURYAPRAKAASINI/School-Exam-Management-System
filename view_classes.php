<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$result = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Classes</title>
</head>
<body>
    <h2>List of Classes</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Class Name</th><th>Section</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['class_id'] ?></td>
            <td><?= htmlspecialchars($row['class_name']) ?></td>
            <td><?= htmlspecialchars($row['section']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">← Back to Dashboard</a>
</body>
</html>
