<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Fetch teacher details along with subject names
$query = "
    SELECT t.teacher_id, t.name AS teacher_name, s.subject_name, t.email
    FROM teachers t
    LEFT JOIN subjects s ON t.subject_id = s.subject_id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Teachers</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('viewteacherspics.jpg') center center / cover no-repeat fixed;
            height: 100vh;
            position: relative;
        }

        /* Dark overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 90%;
            max-width: 1000px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            margin: 60px auto;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 14px;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #eef2f7;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .back-link:hover {
            color: #0056b3;
        }

        @media (max-width: 600px) {
            th, td {
                font-size: 14px;
                padding: 10px;
            }

            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📋 List of Teachers</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Subject</th>
            <th>Email</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['teacher_id']) ?></td>
            <td><?= htmlspecialchars($row['teacher_name']) ?></td>
            <td><?= htmlspecialchars($row['subject_name'] ?: 'No Subject Assigned') ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>
