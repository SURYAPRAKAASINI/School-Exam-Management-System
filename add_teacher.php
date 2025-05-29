<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

$message = "";

// Fetch subjects from DB
$subjects = [];
$subject_query = "SELECT subject_id, subject_name FROM subjects";
$result = $conn->query($subject_query);
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject_id = $_POST['subject_id'];

    if (!empty($name) && !empty($email) && !empty($subject_id)) {
        $query = "INSERT INTO teachers (name, email, subject_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $name, $email, $subject_id);
        if ($stmt->execute()) {
            $message = "✅ Teacher added successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "⚠️ Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('teacherscute.jpg') center center / cover no-repeat fixed;
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

        .form-container {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.97);
            padding: 30px;
            max-width: 500px;
            margin: 80px auto;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        h2 {
            text-align: center;
            color: #222;
            margin-bottom: 25px;
        }

        form input[type="text"],
        form input[type="email"],
        form select {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        form input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #218838;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: #007bff;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .back-link:hover {
            color: #0056b3;
        }

        @media (max-width: 600px) {
            .form-container {
                margin: 40px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>➕ Add Teacher</h2>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Teacher Name" required>
            <input type="email" name="email" placeholder="Email Address" required>

            <select name="subject_id" required>
                <option value="">-- Select Subject --</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= $subject['subject_id'] ?>">
                        <?= htmlspecialchars($subject['subject_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Add Teacher">
        </form>

        <?php if (!empty($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <a class="back-link" href="dashboard.php">🔙 Back to Dashboard</a>
    </div>
</body>
</html>
