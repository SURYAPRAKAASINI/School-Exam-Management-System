<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

$message = "";

// Fetch teachers and subjects
$teachers = $conn->query("SELECT teacher_id, name FROM teachers");
$subjects = $conn->query("SELECT subject_id, subject_name FROM subjects");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $subject_id = $_POST['subject_id'];
    $class_name = trim($_POST['class_name']);

    if (!empty($teacher_id) && !empty($subject_id) && !empty($class_name)) {
        // Insert assignment into the database
        $query = "INSERT INTO assignments (teacher_id, subject_id, class_name) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iis", $teacher_id, $subject_id, $class_name);

        if ($stmt->execute()) {
            $message = "✅ Teacher assigned successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "⚠️ All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Teacher</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .form-container {
            background: white;
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>📘 Assign Teacher to Subject</h2>
        <form method="POST" action="">
            <label for="teacher_id">Select Teacher:</label>
            <select name="teacher_id" required>
                <option value="">-- Choose Teacher --</option>
                <?php while ($row = $teachers->fetch_assoc()): ?>
                    <option value="<?= $row['teacher_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="subject_id">Select Subject:</label>
            <select name="subject_id" required>
                <option value="">-- Choose Subject --</option>
                <?php while ($row = $subjects->fetch_assoc()): ?>
                    <option value="<?= $row['subject_id'] ?>"><?= htmlspecialchars($row['subject_name']) ?></option>
                <?php endwhile; ?>
            </select>

            <input type="text" name="class_name" placeholder="Enter Class (e.g., 10A)" required>

            <input type="submit" value="Assign Teacher">
        </form>
        <?php if (!empty($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
