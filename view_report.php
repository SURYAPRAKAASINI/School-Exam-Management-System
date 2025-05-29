<?php
require 'db_connect.php';

$students = $conn->query("SELECT student_id, name FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Reports</title>
    <style>
        body {
            background-image: url('reports.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            padding: 30px;
            color: #333; /* Dark text color for better readability */
        }
        .container {
            background: rgba(0, 0, 0, 0.5); /* Darker background for content */
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #fff; /* White text for headings */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); /* Text shadow for better contrast */
        }
        .report {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            color: #fff; /* White text for table data */
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7); /* Text shadow for table data */
        }
        select, button {
            padding: 10px;
            width: 100%;
            margin-top: 10px;
        }
        button {
            background-color: #ff6699;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #e65c87;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
        a:hover { color: #0056b3; }
    </style>
</head>
<body>

<div class="container">
    <h2>View Student Report</h2>

    <!-- Form to select a student -->
    <form method="GET">
        <label for="student_id" style="color: #fff;">Select Student:</label>
        <select name="student_id" required>
            <option value="">-- Select Student --</option>
            <?php while($row = $students->fetch_assoc()): ?>
                <option value="<?= $row['student_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">View Report</button>
    </form>

    <!-- Display report if student is selected -->
    <?php if (isset($_GET['student_id'])):
        $student_id = $_GET['student_id'];
        $result = $conn->query("SELECT subject, exam, marks_obtained FROM marks WHERE student_id = '$student_id'");
    ?>
    <div class="report">
        <h3>Report Card</h3>
        <table>
            <tr>
                <th>Subject</th>
                <th>Exam</th>
                <th>Marks Obtained</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['subject']) ?></td>
                <td><?= htmlspecialchars($row['exam']) ?></td>
                <td><?= htmlspecialchars($row['marks_obtained']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <?php endif; ?>

    <!-- Back to Dashboard link -->
    <a href="dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>
