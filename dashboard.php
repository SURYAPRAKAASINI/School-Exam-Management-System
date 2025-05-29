<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - School Exam System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('dashboard.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .overlay {
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .navbar {
            background-color: rgba(52, 58, 64, 0.95);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            font-size: 24px;
            margin: 0;
            color: yellow;
        }

        .navbar a.logout {
            color: #ff4d4d;
            font-weight: bold;
            margin-left: 20px;
            text-decoration: none;
        }

        .container {
            padding: 40px;
            text-align: center;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 40px;
            color: white;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: transform 0.2s ease;
            font-size: 18px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .card a:hover {
            color: #0056b3;
        }

        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar h1 {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="overlay">
        <div class="navbar">
            <h1>Welcome, <?= $_SESSION['user'] ?></h1>
            <div>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </div>

        <div class="container">
            <h2>School Exam Management Dashboard</h2>
            <div class="grid">
                <div class="card"><a href="add_student.php">➕ Add Student</a></div>
                <div class="card"><a href="add_subject.php">📘 Add Subject</a></div>
                <div class="card"><a href="add_exam.php">📝 Add Exam</a></div>
                <div class="card"><a href="enter_marks.php">✏️ Enter Marks</a></div>
                <div class="card"><a href="view_report.php">📊 View Reports</a></div>
                <div class="card"><a href="exam_scheduling.php">📅 Exam Scheduling</a></div>
                <div class="card"><a href="hall_allotment.php">🏫 Hall Allotment</a></div>
                <div class="card"><a href="attendance_tracking.php">📋 Attendance Tracking</a></div>
                <div class="card"><a href="add_teacher.php">👩‍🏫 Add Teacher</a></div>
                <div class="card"><a href="view_teachers.php">👀 View Teachers</a></div>
            </div>
        </div>
    </div>

</body>
</html>
