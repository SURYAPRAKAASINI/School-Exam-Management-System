<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = trim($_POST['class_name']);
    $section = trim($_POST['section']);

    if ($class_name && $section) {
        $stmt = $conn->prepare("INSERT INTO classes (class_name, section) VALUES (?, ?)");
        $stmt->bind_param("ss", $class_name, $section);
        if ($stmt->execute()) {
            $success = "✅ Class added successfully!";
        } else {
            $error = "❌ Failed to add class.";
        }
        $stmt->close();
    } else {
        $error = "⚠️ Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Class</title>
</head>
<body>
    <h2>Add Class</h2>
    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="class_name" placeholder="Class Name" required><br>
        <input type="text" name="section" placeholder="Section" required><br>
        <button type="submit">Add Class</button>
    </form>
    <a href="dashboard.php">← Back to Dashboard</a>
</body>
</html>
