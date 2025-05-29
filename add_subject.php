<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_name = $_POST['subject_name'];
    $stmt = $conn->prepare("INSERT INTO subjects (subject_name) VALUES (?)");
    $stmt->bind_param("s", $subject_name);
    $stmt->execute();
    $stmt->close();
    $message = "Subject added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Subject</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('bookspics.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1); /* transparent white for glass effect */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 90%;
            color: white;
        }

        h2 {
            text-align: center;
            color: #ffccff; /* soft pink title */
        }

        input, button {
            display: block;
            width: 100%;
            margin: 12px 0;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            border: none;
        }

        input {
            background: rgba(255, 255, 255, 0.85);
            color: #000;
            border: 1px solid #ccc;
        }

        button {
            background: #ff66b2;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #cc3385;
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
        <h2>Add Subject</h2>
        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
        <form method="post">
            <input type="text" name="subject_name" placeholder="Enter subject name" required>
            <button type="submit">Add Subject</button>
        </form>
        <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
