<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('logoutpics.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.6);
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        h2 {
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 28px;
        }

        p {
            color: #dddddd;
            font-size: 16px;
        }

        .btn {
            margin-top: 25px;
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            h2 {
                font-size: 22px;
            }

            .btn {
                font-size: 14px;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="overlay">
        <h2>You have successfully logged out</h2>
        <p>Thank you for using the School Exam Management System.</p>
        <a href="index.php" class="btn">Login Again</a>
    </div>
</body>
</html>
