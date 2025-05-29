<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $stmt = $conn->prepare("INSERT INTO students (name, class) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $class);
    $stmt->execute();
    $stmt->close();
    $message = "Student added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('studentspics.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            backdrop-filter: blur(10px); /* Glass effect */
            background-color: rgba(255, 255, 255, 0.1); /* Transparent white */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 90%;
            color: white;
        }

        h2 {
            color: #ffcc00;
            text-align: center;
            margin-bottom: 20px;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input {
            background: rgba(255, 255, 255, 0.8);
            color: #000;
        }

        button {
            background-color: #ffcc00;
            color: black;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #e6b800;
        }

        .message {
            color: #00ff00;
            text-align: center;
            margin-bottom: 10px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #ffcc00;
            font-weight: bold;
        }

        .back-link:hover {
            color: #fff200;
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
        <h2>Add Student</h2>
        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
        <form method="post">
            <input type="text" name="name" placeholder="Enter student name" required>
            <input type="text" name="class" placeholder="Enter class" required>
            <button type="submit">Add Student</button>
        </form>
        <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>

