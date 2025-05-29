<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];
    $stmt = $conn->prepare("INSERT INTO exams (exam_name, exam_date) VALUES (?, ?)");
    $stmt->bind_param("ss", $exam_name, $exam_date);
    $stmt->execute();
    $stmt->close();
    $message = "Exam added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Exam</title>
    <style>
        body {
            margin: 0;
            font-family: 'Verdana', sans-serif;
            background: url('exams.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 30px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            color: #fff;
        }

        h2 {
            text-align: center;
            color: #ffe6f0;
        }

        input, button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border-radius: 8px;
            font-size: 16px;
            border: none;
        }

        input {
            background: rgba(255, 255, 255, 0.85);
            color: #000;
        }

        button {
            background-color: #ff66b2;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #cc3385;
        }

        .message {
            text-align: center;
            color: #00ff00;
            margin-bottom: 10px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #ff99cc;
            font-weight: bold;
        }

        .back-link:hover {
            color: #ffe6f0;
        }

        @media (max-width: 500px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Exam</h2>
        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
        <form method="post">
            <input type="text" name="exam_name" placeholder="Exam name" required>
            <input type="date" name="exam_date" required>
            <button type="submit">Add Exam</button>
        </form>
        <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
