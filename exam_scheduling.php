<?php
require 'db_connect.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $exam_date = $_POST['exam_date'];
    $exam_time = $_POST['exam_time'];
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);

    $sql = "INSERT INTO exam_schedule (subject, exam_date, exam_time, duration)
            VALUES ('$subject', '$exam_date', '$exam_time', '$duration')";

    if ($conn->query($sql) === TRUE) {
        $success = "✅ Exam scheduled successfully!";
    } else {
        $error = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exam Scheduling</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('schedulespics.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            color: #ffffff;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #fff9f9;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            color: #fff;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            margin: 10px 0;
            font-size: 15px;
            background: rgba(255, 255, 255, 0.9);
            color: #000;
        }

        button {
            background-color: #ff6699;
            color: white;
            font-weight: bold;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #e65c87;
        }

        .success {
            color: #00ff99;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .error {
            color: #ff4d4d;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            color: #f8f8f8;
        }

        a:hover {
            color: #fff;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📅 Schedule Exam</h2>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <label>Subject:</label>
            <input type="text" name="subject" required>

            <label>Exam Date:</label>
            <input type="date" name="exam_date" required>

            <label>Exam Time:</label>
            <input type="time" name="exam_time" required>

            <label>Duration (in minutes):</label>
            <input type="number" name="duration" required>

            <button type="submit">Schedule Exam</button>
        </form>
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
