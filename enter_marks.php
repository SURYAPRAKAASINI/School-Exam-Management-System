<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $subject = trim($_POST['subject']);
    $exam = trim($_POST['exam']);
    $marks_obtained = $_POST['marks'];

    if ($student_id && $subject && $exam && is_numeric($marks_obtained)) {
        $stmt = $conn->prepare("INSERT INTO marks (student_id, subject, exam, marks_obtained) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $student_id, $subject, $exam, $marks_obtained);
        if ($stmt->execute()) {
            $success = "✅ Marks entered successfully!";
        } else {
            $error = "❌ Failed to insert marks.";
        }
        $stmt->close();
    } else {
        $error = "⚠️ Please fill all fields correctly.";
    }
}

$students = $conn->query("SELECT student_id, name FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter Marks</title>
    <style>
        body {
            margin: 0;
            padding: 40px;
            font-family: 'Segoe UI', sans-serif;
            background: url('markspics.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .box {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            max-width: 600px;
            margin: auto;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            color: #000;
        }

        h2 {
            text-align: center;
            font-size: 26px;
            margin-bottom: 20px;
        }

        select, input, button {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            color: #000;
        }

        button {
            background-color: #3399ff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #267acc;
        }

        .success {
            color: green;
            font-weight: bold;
            text-align: center;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: bold;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            transition: background 0.3s ease;
        }

        .back-link:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            .box {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>📊 Enter Student Marks</h2>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>

        <form method="post">
            <select name="student_id" required>
                <option value="">Select Student</option>
                <?php while ($row = $students->fetch_assoc()): ?>
                    <option value="<?= $row['student_id']; ?>"><?= htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            </select>
            <input type="text" name="subject" placeholder="Enter Subject" required>
            <input type="text" name="exam" placeholder="Enter Exam" required>
            <input type="number" name="marks" placeholder="Enter Marks" min="0" required>
            <button type="submit">Submit Marks</button>
        </form>

        <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
