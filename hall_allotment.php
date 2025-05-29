<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_name = $_POST['exam_name'];
    $hall_number = $_POST['hall_number'];
    $capacity = $_POST['capacity'];
    $invigilator = $_POST['invigilator'];

    $stmt = $conn->prepare("INSERT INTO hall_allotment (exam_name, hall_number, capacity, invigilator) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $exam_name, $hall_number, $capacity, $invigilator);
    $stmt->execute();
    $success = "✅ Hall Allotment Saved!";
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hall Allotment</title>
    <style>
        body {
            margin: 0;
            padding: 40px;
            font-family: 'Segoe UI', sans-serif;
            background: url('hallpics.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            max-width: 500px;
            margin: auto;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
        }

        input, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            color: #000;
        }

        button {
            background-color: #ff6699;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #e65c87;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            background: #007bff;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            text-decoration: none;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .back-link:hover {
            background-color: #0056b3;
        }

        .success {
            color: #00ff00;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
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
        <h2>🏫 Hall Allotment</h2>
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>
        <form method="post">
            <input type="text" name="exam_name" placeholder="Exam Name" required>
            <input type="text" name="hall_number" placeholder="Hall Number" required>
            <input type="number" name="capacity" placeholder="Capacity" required>
            <input type="text" name="invigilator" placeholder="Invigilator Name" required>
            <button type="submit">Allocate Hall</button>
        </form>
        <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
