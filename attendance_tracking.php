<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $exam_name = $_POST['exam_name'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO attendance_tracking (student_name, exam_name, status, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $student_name, $exam_name, $status, $date);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Tracking</title>
    <style>
        body {
            margin: 0;
            padding: 30px;
            font-family: 'Segoe UI', sans-serif;
            background: url('attendancepics.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            max-width: 900px;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            color: #fff;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #fefefe;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 40px;
        }

        label {
            font-weight: bold;
        }

        input, select {
            padding: 10px;
            border-radius: 8px;
            border: none;
            width: 100%;
            font-size: 16px;
            margin-top: 5px;
            background-color: #ffffffcc;
            color: #000;
        }

        input[type="submit"] {
            grid-column: span 2;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.9);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #000;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-weight: bold;
            text-decoration: none;
            color: #ffffff;
            background-color: #007bff;
            padding: 10px 15px;
            border-radius: 8px;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
            transition: background 0.3s ease;
        }

        .back-link:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            form {
                grid-template-columns: 1fr;
            }
            input[type="submit"] {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📋 Attendance Tracking</h2>

        <form method="post" action="">
            <div>
                <label>Student Name:</label>
                <input type="text" name="student_name" required>
            </div>
            <div>
                <label>Exam Name:</label>
                <input type="text" name="exam_name" required>
            </div>
            <div>
                <label>Status:</label>
                <select name="status" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>
            <div>
                <label>Date:</label>
                <input type="date" name="date" required>
            </div>
            <input type="submit" value="Save Attendance">
        </form>

        <h2>📑 Attendance Records</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Exam Name</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM attendance_tracking ORDER BY id DESC");
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['student_name']}</td>
                        <td>{$row['exam_name']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['date']}</td>
                    </tr>";
            }
            ?>
        </table>

        <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
