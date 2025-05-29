<?php
session_start();
require 'db_connect.php';

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - School Exam System</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('school.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: #ffffff;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            width: 360px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #444;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            background: none;
        }

        .form-group label {
            position: absolute;
            top: 12px;
            left: 12px;
            color: #888;
            pointer-events: none;
            transition: 0.2s ease all;
            background: white;
            padding: 0 5px;
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            top: -9px;
            left: 10px;
            font-size: 12px;
            color: #007bff;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        @media (max-width: 400px) {
            .login-box {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <div class="form-group">
                <input type="text" name="username" id="username" required placeholder=" " />
                <label for="username">Username</label>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" required placeholder=" " />
                <label for="password">Password</label>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
